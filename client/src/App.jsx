import { useMemo, useState } from 'react'
import { artisans as artisanSeed, categories, initialBookings, initialNotifications } from './data/seedData'
import './App.css'

const emptyBooking = {
  clientName: '',
  clientPhone: '',
  address: '',
  preferredDate: '',
  preferredTime: '',
  description: '',
}

const emptyArtisan = {
  name: '',
  category: 'Plumbing',
  location: '',
  yearsExperience: '',
  hourlyRate: '',
  availability: 'Available this week',
  nextSlot: '',
  skills: '',
  bio: '',
}

function App() {
  const [artisans, setArtisans] = useState(artisanSeed)
  const [bookings, setBookings] = useState(initialBookings)
  const [notifications, setNotifications] = useState(initialNotifications)
  const [selectedArtisanId, setSelectedArtisanId] = useState(artisanSeed[0].id)
  const [bookingForm, setBookingForm] = useState(emptyBooking)
  const [artisanForm, setArtisanForm] = useState(emptyArtisan)
  const [filters, setFilters] = useState({
    query: '',
    category: 'All services',
    availability: 'Any availability',
    minRating: '0',
  })
  const [message, setMessage] = useState('')

  const selectedArtisan = artisans.find((artisan) => artisan.id === selectedArtisanId) || artisans[0]

  const filteredArtisans = useMemo(() => {
    return artisans.filter((artisan) => {
      const query = filters.query.toLowerCase()
      const matchesQuery =
        !query ||
        [artisan.name, artisan.category, artisan.location, artisan.bio, ...artisan.skills]
          .join(' ')
          .toLowerCase()
          .includes(query)
      const matchesCategory = filters.category === 'All services' || artisan.category === filters.category
      const matchesAvailability =
        filters.availability === 'Any availability' ||
        artisan.availability.toLowerCase().includes(filters.availability.toLowerCase())
      const matchesRating = artisan.rating >= Number(filters.minRating)

      return matchesQuery && matchesCategory && matchesAvailability && matchesRating
    })
  }, [artisans, filters])

  const averageRating = (
    artisans.reduce((total, artisan) => total + artisan.rating, 0) / Math.max(artisans.length, 1)
  ).toFixed(1)

  function updateBookingField(event) {
    setBookingForm((current) => ({
      ...current,
      [event.target.name]: event.target.value,
    }))
  }

  function updateArtisanField(event) {
    setArtisanForm((current) => ({
      ...current,
      [event.target.name]: event.target.value,
    }))
  }

  function updateFilter(event) {
    setFilters((current) => ({
      ...current,
      [event.target.name]: event.target.value,
    }))
  }

  function submitBooking(event) {
    event.preventDefault()

    const booking = {
      id: bookings.length + 1,
      artisanName: selectedArtisan.name,
      serviceType: selectedArtisan.category,
      clientName: bookingForm.clientName,
      preferredDate: bookingForm.preferredDate,
      preferredTime: bookingForm.preferredTime,
      status: 'pending',
      description: bookingForm.description,
    }

    setBookings((current) => [booking, ...current])
    setNotifications((current) => [
      {
        id: current.length + 1,
        title: 'New booking request',
        message: `${booking.clientName} requested ${booking.serviceType} service from ${booking.artisanName}.`,
        unread: true,
      },
      ...current,
    ])
    setBookingForm(emptyBooking)
    setMessage(`Booking request sent to ${selectedArtisan.name}.`)
  }

  function submitArtisan(event) {
    event.preventDefault()

    const artisan = {
      id: artisans.length + 1,
      name: artisanForm.name,
      category: artisanForm.category,
      location: artisanForm.location,
      verified: false,
      yearsExperience: Number(artisanForm.yearsExperience),
      hourlyRate: Number(artisanForm.hourlyRate),
      rating: 0,
      reviewCount: 0,
      jobsCompleted: 0,
      availability: artisanForm.availability,
      nextSlot: artisanForm.nextSlot || 'To be updated',
      skills: artisanForm.skills
        .split(',')
        .map((skill) => skill.trim())
        .filter(Boolean),
      bio: artisanForm.bio,
    }

    setArtisans((current) => [artisan, ...current])
    setSelectedArtisanId(artisan.id)
    setArtisanForm(emptyArtisan)
    setMessage(`${artisan.name} has been added to the artisan directory pending verification.`)
  }

  function markNotificationRead(id) {
    setNotifications((current) =>
      current.map((notification) =>
        notification.id === id ? { ...notification, unread: false } : notification,
      ),
    )
  }

  return (
    <main>
      <header className="site-header">
        <a className="brand" href="#top" aria-label="Koforidua Artisan Connect home">
          <span className="brand-mark">KA</span>
          <span>
            <strong>Koforidua Artisan Connect</strong>
            <small>Verified local service booking</small>
          </span>
        </a>
        <nav aria-label="Primary navigation">
          <a href="#artisans">Find artisans</a>
          <a href="#booking">Book service</a>
          <a href="#artisan-register">Artisan portal</a>
        </nav>
      </header>

      <section className="hero-section" id="top">
        <div className="hero-copy">
          <p className="eyebrow">Web application for Koforidua Municipality</p>
          <h1>Book trusted plumbers, electricians, carpenters, masons, and more.</h1>
          <p>
            A dual-interface marketplace where clients discover verified artisans and artisans manage
            profiles, availability, bookings, ratings, and notifications online.
          </p>
          <div className="hero-actions">
            <a className="button primary" href="#artisans">
              Search artisans
            </a>
            <a className="button secondary" href="#artisan-register">
              Register artisan
            </a>
          </div>
        </div>
        <aside className="hero-panel" aria-label="Study findings">
          <div>
            <span className="metric">78%</span>
            <p>of surveyed users rely on word-of-mouth to find artisans.</p>
          </div>
          <div>
            <span className="metric">82.4</span>
            <p>System Usability Scale score from representative end-user evaluation.</p>
          </div>
        </aside>
      </section>

      {message && (
        <div className="status-message" role="status">
          {message}
        </div>
      )}

      <section className="stats-grid" aria-label="System summary">
        <article>
          <span>{artisans.length}</span>
          <p>Artisans listed</p>
        </article>
        <article>
          <span>{bookings.length}</span>
          <p>Booking records</p>
        </article>
        <article>
          <span>{averageRating}</span>
          <p>Average rating</p>
        </article>
        <article>
          <span>{notifications.filter((notification) => notification.unread).length}</span>
          <p>Unread notifications</p>
        </article>
      </section>

      <section className="content-section" id="artisans">
        <div className="section-heading">
          <p className="eyebrow">Client interface</p>
          <h2>Search, filter, and compare verified artisans</h2>
          <p>
            Filter by trade, location, availability, rating, or skill to reduce the friction of service
            discovery.
          </p>
        </div>

        <form className="filter-card" aria-label="Filter artisans">
          <label>
            Search keyword
            <input
              name="query"
              value={filters.query}
              onChange={updateFilter}
              placeholder="e.g. Srodae, leak, wiring"
            />
          </label>
          <label>
            Service category
            <select name="category" value={filters.category} onChange={updateFilter}>
              {categories.map((category) => (
                <option key={category}>{category}</option>
              ))}
            </select>
          </label>
          <label>
            Availability
            <select name="availability" value={filters.availability} onChange={updateFilter}>
              <option>Any availability</option>
              <option>Available today</option>
              <option>Available tomorrow</option>
              <option>Busy this week</option>
            </select>
          </label>
          <label>
            Minimum rating
            <select name="minRating" value={filters.minRating} onChange={updateFilter}>
              <option value="0">Any rating</option>
              <option value="4">4.0+</option>
              <option value="4.5">4.5+</option>
              <option value="4.8">4.8+</option>
            </select>
          </label>
        </form>

        <div className="artisan-grid">
          {filteredArtisans.map((artisan) => (
            <article
              className={`artisan-card ${selectedArtisan.id === artisan.id ? 'selected' : ''}`}
              key={artisan.id}
            >
              <div className="card-topline">
                <span className="category-pill">{artisan.category}</span>
                {artisan.verified ? <span className="verified">Verified</span> : <span>Pending</span>}
              </div>
              <h3>{artisan.name}</h3>
              <p>{artisan.bio}</p>
              <dl className="card-details">
                <div>
                  <dt>Location</dt>
                  <dd>{artisan.location}</dd>
                </div>
                <div>
                  <dt>Rating</dt>
                  <dd>
                    {artisan.rating || 'New'} ({artisan.reviewCount} reviews)
                  </dd>
                </div>
                <div>
                  <dt>Rate</dt>
                  <dd>GHS {artisan.hourlyRate}/hr</dd>
                </div>
                <div>
                  <dt>Next slot</dt>
                  <dd>{artisan.nextSlot}</dd>
                </div>
              </dl>
              <div className="skills-list">
                {artisan.skills.map((skill) => (
                  <span key={skill}>{skill}</span>
                ))}
              </div>
              <button type="button" onClick={() => setSelectedArtisanId(artisan.id)}>
                Select for booking
              </button>
            </article>
          ))}
        </div>
      </section>

      <section className="split-section" id="booking">
        <div className="section-heading">
          <p className="eyebrow">Booking workflow</p>
          <h2>Request a service appointment</h2>
          <p>
            Booking requests are captured with schedule, address, client contact, selected artisan, and
            service description.
          </p>
        </div>

        <form className="panel-card" onSubmit={submitBooking}>
          <h3>Selected artisan: {selectedArtisan.name}</h3>
          <div className="form-grid">
            <label>
              Client name
              <input name="clientName" value={bookingForm.clientName} onChange={updateBookingField} required />
            </label>
            <label>
              Phone number
              <input name="clientPhone" value={bookingForm.clientPhone} onChange={updateBookingField} required />
            </label>
            <label>
              Preferred date
              <input
                type="date"
                name="preferredDate"
                value={bookingForm.preferredDate}
                onChange={updateBookingField}
                required
              />
            </label>
            <label>
              Preferred time
              <input
                type="time"
                name="preferredTime"
                value={bookingForm.preferredTime}
                onChange={updateBookingField}
                required
              />
            </label>
          </div>
          <label>
            Service address
            <input name="address" value={bookingForm.address} onChange={updateBookingField} required />
          </label>
          <label>
            Problem description
            <textarea
              name="description"
              value={bookingForm.description}
              onChange={updateBookingField}
              rows="4"
              required
            />
          </label>
          <button className="button primary" type="submit">
            Submit booking request
          </button>
        </form>
      </section>

      <section className="dashboard-grid" aria-label="Management dashboards">
        <article className="panel-card">
          <h2>Booking history</h2>
          <div className="list-stack">
            {bookings.map((booking) => (
              <div className="list-item" key={booking.id}>
                <div>
                  <strong>{booking.serviceType}</strong>
                  <p>
                    {booking.clientName} with {booking.artisanName} on {booking.preferredDate} at{' '}
                    {booking.preferredTime}
                  </p>
                </div>
                <span className={`status-badge ${booking.status}`}>{booking.status}</span>
              </div>
            ))}
          </div>
        </article>

        <article className="panel-card">
          <h2>Notifications</h2>
          <div className="list-stack">
            {notifications.map((notification) => (
              <button
                className={`notification-item ${notification.unread ? 'unread' : ''}`}
                key={notification.id}
                type="button"
                onClick={() => markNotificationRead(notification.id)}
              >
                <strong>{notification.title}</strong>
                <span>{notification.message}</span>
              </button>
            ))}
          </div>
        </article>
      </section>

      <section className="split-section" id="artisan-register">
        <div className="section-heading">
          <p className="eyebrow">Artisan interface</p>
          <h2>Register profile and manage availability</h2>
          <p>
            Artisans can create a professional profile, list skills, publish availability, and receive
            booking notifications.
          </p>
        </div>

        <form className="panel-card" onSubmit={submitArtisan}>
          <div className="form-grid">
            <label>
              Artisan name
              <input name="name" value={artisanForm.name} onChange={updateArtisanField} required />
            </label>
            <label>
              Trade category
              <select name="category" value={artisanForm.category} onChange={updateArtisanField}>
                {categories
                  .filter((category) => category !== 'All services')
                  .map((category) => (
                    <option key={category}>{category}</option>
                  ))}
              </select>
            </label>
            <label>
              Location
              <input name="location" value={artisanForm.location} onChange={updateArtisanField} required />
            </label>
            <label>
              Years experience
              <input
                type="number"
                min="0"
                name="yearsExperience"
                value={artisanForm.yearsExperience}
                onChange={updateArtisanField}
                required
              />
            </label>
            <label>
              Hourly rate (GHS)
              <input
                type="number"
                min="0"
                name="hourlyRate"
                value={artisanForm.hourlyRate}
                onChange={updateArtisanField}
                required
              />
            </label>
            <label>
              Next available slot
              <input name="nextSlot" value={artisanForm.nextSlot} onChange={updateArtisanField} />
            </label>
          </div>
          <label>
            Skills, separated by commas
            <input
              name="skills"
              value={artisanForm.skills}
              onChange={updateArtisanField}
              placeholder="Wiring, sockets, inspection"
              required
            />
          </label>
          <label>
            Profile bio
            <textarea name="bio" value={artisanForm.bio} onChange={updateArtisanField} rows="4" required />
          </label>
          <button className="button primary" type="submit">
            Register artisan profile
          </button>
        </form>
      </section>
    </main>
  )
}

export default App
