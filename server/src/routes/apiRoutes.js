import express from 'express';
import { z } from 'zod';
import { validate } from '../middleware/validate.js';
import {
  createBooking,
  createReview,
  findArtisanById,
  findArtisans,
  getBookings,
  getCategories,
  getDashboardSummary,
  getNotifications,
  getReviews,
  loginUser,
  markNotificationRead,
  registerArtisan,
  registerUser,
  updateArtisanAvailability,
  updateBookingStatus,
} from '../services/marketplaceService.js';

export const apiRoutes = express.Router();

const idParam = z.object({
  params: z.object({
    id: z.coerce.number().int().positive(),
  }),
});

const registerUserSchema = z.object({
  body: z.object({
    fullName: z.string().min(2),
    email: z.email(),
    phone: z.string().min(7),
    password: z.string().min(6),
    role: z.enum(['client', 'artisan']),
  }),
});

const loginSchema = z.object({
  body: z.object({
    email: z.email(),
    password: z.string().min(1),
  }),
});

const artisanSchema = z.object({
  body: z.object({
    userId: z.number().int().positive().optional(),
    name: z.string().min(2),
    categoryId: z.coerce.number().int().positive(),
    category: z.string().optional(),
    location: z.string().min(2),
    yearsExperience: z.coerce.number().min(0),
    hourlyRate: z.coerce.number().min(0),
    availability: z.string().optional(),
    nextSlot: z.string().optional(),
    skills: z.array(z.string()).default([]),
    bio: z.string().default(''),
  }),
});

const availabilitySchema = idParam.extend({
  body: z.object({
    availability: z.string().min(2),
    nextSlot: z.string().min(2),
  }),
});

const bookingSchema = z.object({
  body: z.object({
    clientName: z.string().min(2),
    clientPhone: z.string().min(7),
    artisanId: z.coerce.number().int().positive(),
    artisanName: z.string().optional(),
    serviceType: z.string().optional(),
    address: z.string().min(3),
    preferredDate: z.string().min(8),
    preferredTime: z.string().min(4),
    description: z.string().min(8),
  }),
});

const bookingStatusSchema = idParam.extend({
  body: z.object({
    status: z.enum(['pending', 'confirmed', 'completed', 'cancelled']),
  }),
});

const reviewSchema = z.object({
  body: z.object({
    artisanId: z.coerce.number().int().positive(),
    clientName: z.string().min(2),
    rating: z.coerce.number().int().min(1).max(5),
    comment: z.string().min(4),
  }),
});

apiRoutes.get('/health', async (req, res) => {
  res.json({ status: 'ok', service: 'artisan-booking-api' });
});

apiRoutes.get('/dashboard/summary', (req, res) => {
  res.json(getDashboardSummary());
});

apiRoutes.post('/auth/register', validate(registerUserSchema), async (req, res, next) => {
  try {
    const user = await registerUser(req.validated.body);
    res.status(201).json(user);
  } catch (error) {
    next(error);
  }
});

apiRoutes.post('/auth/login', validate(loginSchema), async (req, res, next) => {
  try {
    res.json(await loginUser(req.validated.body));
  } catch (error) {
    next(error);
  }
});

apiRoutes.get('/categories', (req, res) => {
  res.json(getCategories());
});

apiRoutes.get('/artisans', (req, res) => {
  res.json(findArtisans(req.query));
});

apiRoutes.get('/artisans/:id', validate(idParam), (req, res) => {
  const artisan = findArtisanById(req.validated.params.id);
  if (!artisan) return res.status(404).json({ error: 'Artisan not found' });

  return res.json(artisan);
});

apiRoutes.post('/artisans', validate(artisanSchema), (req, res) => {
  res.status(201).json(registerArtisan(req.validated.body));
});

apiRoutes.patch('/artisans/:id/availability', validate(availabilitySchema), (req, res) => {
  const artisan = updateArtisanAvailability(req.validated.params.id, req.validated.body);
  if (!artisan) return res.status(404).json({ error: 'Artisan not found' });

  return res.json(artisan);
});

apiRoutes.get('/bookings', (req, res) => {
  res.json(getBookings(req.query));
});

apiRoutes.post('/bookings', validate(bookingSchema), (req, res) => {
  res.status(201).json(createBooking(req.validated.body));
});

apiRoutes.patch('/bookings/:id/status', validate(bookingStatusSchema), (req, res) => {
  const booking = updateBookingStatus(req.validated.params.id, req.validated.body.status);
  if (!booking) return res.status(404).json({ error: 'Booking not found' });

  return res.json(booking);
});

apiRoutes.get('/reviews', (req, res) => {
  res.json(getReviews(req.query.artisanId));
});

apiRoutes.post('/reviews', validate(reviewSchema), (req, res) => {
  res.status(201).json(createReview(req.validated.body));
});

apiRoutes.get('/notifications', (req, res) => {
  res.json(getNotifications(req.query.userId));
});

apiRoutes.patch('/notifications/:id/read', validate(idParam), (req, res) => {
  const notification = markNotificationRead(req.validated.params.id);
  if (!notification) return res.status(404).json({ error: 'Notification not found' });

  return res.json(notification);
});
