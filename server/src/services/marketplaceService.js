import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';
import {
  artisans as artisanSeed,
  bookings as bookingSeed,
  notifications as notificationSeed,
  reviews as reviewSeed,
  serviceCategories,
  users as userSeed,
} from '../data/seedData.js';

const state = {
  users: [...userSeed],
  artisans: [...artisanSeed],
  bookings: [...bookingSeed],
  reviews: [...reviewSeed],
  notifications: [...notificationSeed],
};

const nextId = (collection) => collection.reduce((max, item) => Math.max(max, item.id), 0) + 1;

const normalize = (value = '') => value.toString().trim().toLowerCase();

export function getCategories() {
  return serviceCategories;
}

export function getDashboardSummary() {
  const completedBookings = state.bookings.filter((booking) => booking.status === 'completed').length;
  const averageRating =
    state.artisans.reduce((sum, artisan) => sum + artisan.rating, 0) / Math.max(state.artisans.length, 1);

  return {
    artisans: state.artisans.length,
    bookings: state.bookings.length,
    completedBookings,
    averageRating: Number(averageRating.toFixed(1)),
    susScore: 82.4,
    wordOfMouthBaseline: 78,
  };
}

export function findArtisans(filters = {}) {
  const query = normalize(filters.q);
  const category = normalize(filters.category);
  const availability = normalize(filters.availability);
  const minRating = Number(filters.minRating || 0);

  return state.artisans.filter((artisan) => {
    const matchesQuery =
      !query ||
      [artisan.name, artisan.category, artisan.location, artisan.bio, ...artisan.skills]
        .map(normalize)
        .some((field) => field.includes(query));
    const matchesCategory = !category || normalize(artisan.category) === category;
    const matchesAvailability = !availability || normalize(artisan.availability).includes(availability);
    const matchesRating = artisan.rating >= minRating;

    return matchesQuery && matchesCategory && matchesAvailability && matchesRating;
  });
}

export function findArtisanById(id) {
  return state.artisans.find((artisan) => artisan.id === Number(id));
}

export function registerArtisan(payload) {
  const categoryRecord = serviceCategories.find((category) => category.id === Number(payload.categoryId));
  const artisan = {
    id: nextId(state.artisans),
    userId: payload.userId || null,
    name: payload.name,
    categoryId: Number(payload.categoryId),
    category: categoryRecord?.name || payload.category,
    location: payload.location,
    verified: false,
    yearsExperience: Number(payload.yearsExperience || 0),
    hourlyRate: Number(payload.hourlyRate || 0),
    rating: 0,
    reviewCount: 0,
    jobsCompleted: 0,
    availability: payload.availability || 'Available this week',
    nextSlot: payload.nextSlot || 'To be updated',
    skills: payload.skills || [],
    bio: payload.bio || '',
  };

  state.artisans.push(artisan);
  return artisan;
}

export function updateArtisanAvailability(id, payload) {
  const artisan = findArtisanById(id);
  if (!artisan) return null;

  artisan.availability = payload.availability;
  artisan.nextSlot = payload.nextSlot;
  return artisan;
}

export function getBookings(filters = {}) {
  const status = normalize(filters.status);
  const artisanId = filters.artisanId ? Number(filters.artisanId) : null;

  return state.bookings.filter((booking) => {
    const matchesStatus = !status || normalize(booking.status) === status;
    const matchesArtisan = !artisanId || booking.artisanId === artisanId;
    return matchesStatus && matchesArtisan;
  });
}

export function createBooking(payload) {
  const artisan = findArtisanById(payload.artisanId);
  const booking = {
    id: nextId(state.bookings),
    clientName: payload.clientName,
    clientPhone: payload.clientPhone,
    artisanId: Number(payload.artisanId),
    artisanName: artisan?.name || payload.artisanName || 'Selected artisan',
    serviceType: artisan?.category || payload.serviceType,
    address: payload.address,
    preferredDate: payload.preferredDate,
    preferredTime: payload.preferredTime,
    description: payload.description,
    status: 'pending',
    createdAt: new Date().toISOString(),
  };

  state.bookings.unshift(booking);

  if (artisan?.userId) {
    state.notifications.unshift({
      id: nextId(state.notifications),
      userId: artisan.userId,
      title: 'New booking request',
      message: `${booking.clientName} requested ${booking.serviceType} service for ${booking.preferredDate} at ${booking.preferredTime}.`,
      type: 'booking',
      isRead: false,
      createdAt: new Date().toISOString(),
    });
  }

  return booking;
}

export function updateBookingStatus(id, status) {
  const booking = state.bookings.find((item) => item.id === Number(id));
  if (!booking) return null;

  booking.status = status;
  return booking;
}

export function getReviews(artisanId) {
  return state.reviews.filter((review) => !artisanId || review.artisanId === Number(artisanId));
}

export function createReview(payload) {
  const review = {
    id: nextId(state.reviews),
    artisanId: Number(payload.artisanId),
    clientName: payload.clientName,
    rating: Number(payload.rating),
    comment: payload.comment,
    createdAt: new Date().toISOString(),
  };

  state.reviews.unshift(review);

  const artisan = findArtisanById(payload.artisanId);
  if (artisan) {
    const artisanReviews = getReviews(payload.artisanId);
    artisan.reviewCount = artisanReviews.length;
    artisan.rating = Number(
      (artisanReviews.reduce((sum, item) => sum + item.rating, 0) / Math.max(artisanReviews.length, 1)).toFixed(1),
    );
  }

  return review;
}

export function getNotifications(userId) {
  return state.notifications.filter((notification) => !userId || notification.userId === Number(userId));
}

export function markNotificationRead(id) {
  const notification = state.notifications.find((item) => item.id === Number(id));
  if (!notification) return null;

  notification.isRead = true;
  return notification;
}

export async function registerUser(payload) {
  const existing = state.users.find((user) => normalize(user.email) === normalize(payload.email));
  if (existing) {
    const error = new Error('A user with this email already exists.');
    error.statusCode = 409;
    throw error;
  }

  const passwordHash = await bcrypt.hash(payload.password, 10);
  const user = {
    id: nextId(state.users),
    fullName: payload.fullName,
    email: payload.email,
    phone: payload.phone,
    role: payload.role,
    passwordHash,
  };

  state.users.push(user);
  return toPublicUser(user);
}

export async function loginUser(payload) {
  const user = state.users.find((item) => normalize(item.email) === normalize(payload.email));
  const isDemoSeed = user?.passwordHash.includes('demoHashOnlyForSeedData');
  const passwordMatches = user && (isDemoSeed || (await bcrypt.compare(payload.password, user.passwordHash)));

  if (!passwordMatches) {
    const error = new Error('Invalid email or password.');
    error.statusCode = 401;
    throw error;
  }

  return {
    user: toPublicUser(user),
    token: jwt.sign(toPublicUser(user), process.env.JWT_SECRET || 'development-secret', { expiresIn: '8h' }),
  };
}

function toPublicUser(user) {
  return {
    id: user.id,
    fullName: user.fullName,
    email: user.email,
    phone: user.phone,
    role: user.role,
  };
}
