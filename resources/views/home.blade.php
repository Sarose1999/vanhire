@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold text-white mb-4">
                    Find Your Perfect <span class="text-warning">Travel Van</span>
                </h1>
                <p class="lead text-light mb-4">
                    Discover comfortable and reliable vans for all your travel needs.
                    Book with confidence and enjoy your journey with FS TRAVELS.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#vans" class="btn btn-warning btn-lg fw-semibold px-4 py-3">
                        <i class="fas fa-van-shuttle me-2"></i>Explore Vans
                    </a>
                    <a href="#bookings" class="btn btn-outline-light btn-lg fw-semibold px-4 py-3">
                        <i class="fas fa-calendar-check me-2"></i>View Bookings
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image text-center">
                    <img src="{{ asset('images/van-hero.png') }}" alt="Travel Van" class="img-fluid floating-animation"
                         onerror="this.src='https://www.garson.co.jp/english/panel/kdh_trh200_hiace/main.jpg'">
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-2">

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center mb-5 shadow-sm" role="alert" data-aos="fade-down">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Advanced Filter Section -->
    <section class="filter-section mb-5" data-aos="fade-up">
        <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sliders-h me-2"></i>
                    <h4 class="mb-0 fw-semibold">Find Your Perfect Van</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('home') }}" class="row g-4 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-search me-1 text-primary"></i>Van Name
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-van-shuttle text-muted"></i>
                            </span>
                            <input type="text" name="name" value="{{ request('name') }}"
                                   class="form-control border-start-0" placeholder="Search by name...">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-users me-1 text-primary"></i>Min Seats
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-chair text-muted"></i>
                            </span>
                            <input type="number" name="seats" value="{{ request('seats') }}"
                                   class="form-control border-start-0" min="1" placeholder="Seats ≥">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-tag me-1 text-primary"></i>Max Price
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-dollar-sign text-muted"></i>
                            </span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                   class="form-control border-start-0" min="0" placeholder="≤ Price">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 fw-semibold py-2">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Available Vans Section -->
    <section id="vans" class="vans-section mb-5">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-dark mb-3">Available Vans</h2>
            <p class="lead text-muted">Choose from our premium collection of comfortable travel vans</p>
        </div>

        <div class="row g-4">
            @forelse($vans as $van)
            <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card van-card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative
                    @if(isset($latestBookingId) && $van->id == $latestBookingId) new-booking-highlight @endif">

                    <!-- New Booking Badge -->
                    @if(isset($latestBookingId) && $van->id == $latestBookingId)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success badge-glow px-3 py-2">
                                <i class="fas fa-bolt me-1"></i>New Booking
                            </span>
                        </div>
                    @endif

                    <!-- Van Image -->
                    <div class="van-image-container position-relative overflow-hidden">
                        @if($van->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($van->image))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($van->image) }}"
                                 class="card-img-top van-image" alt="{{ $van->name }}">
                        @else
                            <img src="{{ asset('images/default-van.png') }}"
                                 class="card-img-top van-image" alt="No Image"
                                 onerror="this.src='https://images.unsplash.com/photo-1544636331-e26879cd4d9b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">
                        @endif
                        <div class="van-overlay"></div>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="van-header mb-3">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $van->name }}</h5>
                            <div class="van-features d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-users me-1 text-primary"></i>{{ $van->seats }} Seats
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-cog me-1 text-primary"></i>{{ $van->model ?? 'Standard' }}
                                </span>
                            </div>
                        </div>

                        <div class="van-price mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted">Price per day</span>
                                <span class="h5 fw-bold text-primary mb-0">LKR {{ number_format($van->price_per_day) }}</span>
                            </div>
                        </div>

                        <!-- Book Now Button -->
                        <a href="{{ route('bookings.create', $van->id) }}"
                           class="btn btn-primary btn-hover-grow mt-auto fw-semibold py-3">
                            <i class="fas fa-calendar-plus me-2"></i>Book Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" data-aos="fade-up">
                <div class="empty-state py-5">
                    <i class="fas fa-van-shuttle fa-4x text-muted mb-4"></i>
                    <h4 class="text-dark mb-3">No Vans Found</h4>
                    <p class="text-muted mb-4">No vans found matching your search criteria.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-redo me-2"></i>Reset Filters
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </section>

    <!-- User Bookings Section -->
    <section id="bookings" class="bookings-section mb-5">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-dark mb-3">Your Bookings</h2>
            <p class="lead text-muted">Manage and track your van rental bookings</p>
        </div>

        @if(isset($bookings) && $bookings->count() > 0)
        <div class="card border-0 shadow-lg rounded-3 overflow-hidden" data-aos="fade-up">
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-calendar-alt me-2"></i>
                        <h4 class="mb-0 fw-semibold">Booking History</h4>
                    </div>
                    <span class="badge bg-light text-primary fs-6">{{ $bookings->count() }} Bookings</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">Booking ID</th>
                                <th class="py-3 px-4">Van</th>
                                <th class="py-3 px-4">Booking Date</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr class="booking-row">
                                <td class="px-4">
                                    <span class="fw-semibold text-primary">#{{ $booking->id }}</span>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-van-shuttle text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $booking->van->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <i class="far fa-calendar text-muted me-2"></i>
                                    {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-4">
                                    @if($booking->status == 'confirmed')
                                        <span class="badge bg-success badge-pill py-2 px-3">
                                            <i class="fas fa-check-circle me-1"></i>Confirmed
                                        </span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge bg-warning text-dark badge-pill py-2 px-3">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    @elseif($booking->status == 'canceled')
                                        <span class="badge bg-danger badge-pill py-2 px-3">
                                            <i class="fas fa-times-circle me-1"></i>Canceled
                                        </span>
                                    @else
                                        <span class="badge bg-secondary badge-pill py-2 px-3">
                                            <i class="fas fa-question-circle me-1"></i>Unknown
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                           class="btn btn-info btn-sm text-white px-3">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        @if($booking->status == 'pending')
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3 cancel-booking-btn"
                                                data-booking-id="{{ $booking->id }}">
                                                <i class="fas fa-times me-1"></i>Cancel
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-state">
                <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                <h4 class="text-dark mb-3">No Bookings Yet</h4>
                <p class="text-muted mb-4">You haven't made any van bookings yet.</p>
                <a href="#vans" class="btn btn-primary">
                    <i class="fas fa-van-shuttle me-2"></i>Browse Vans
                </a>
            </div>
        </div>
        @endif
    </section>

</div>

<!-- About Us Section -->
<section id="about" class="about-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-dark mb-3">About FS TRAVELS</h2>
            <p class="lead text-muted">Your trusted partner for comfortable and reliable van rentals</p>
        </div>

        <div class="row align-items-center">
            <!-- About Content -->
            <div class="col-lg-6 mb-4" data-aos="fade-right">
                <div class="about-content">
                    <h3 class="fw-bold text-dark mb-4">We Make Your Journey Comfortable</h3>
                    <p class="text-muted mb-4">
                        FS TRAVELS has been providing premium van rental services since 2010.
                        We understand that every journey matters, which is why we offer a fleet
                        of well-maintained, comfortable vans to make your travel experience exceptional.
                    </p>

                    <div class="features-list mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-shield-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Safety First</h6>
                                        <p class="text-muted small mb-0">Regular maintenance & safety checks</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-headset text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">24/7 Support</h6>
                                        <p class="text-muted small mb-0">Round-the-clock customer service</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-tachometer-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Modern Fleet</h6>
                                        <p class="text-muted small mb-0">Latest models with premium features</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Wide Coverage</h6>
                                        <p class="text-muted small mb-0">Service available across the country</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-section mb-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="fw-bold text-primary mb-1">500+</h3>
                                    <p class="text-muted small mb-0">Happy Customers</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="fw-bold text-primary mb-1">50+</h3>
                                    <p class="text-muted small mb-0">Vans Fleet</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="fw-bold text-primary mb-1">12+</h3>
                                    <p class="text-muted small mb-0">Years Experience</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="#vans" class="btn btn-primary btn-lg fw-semibold px-4 py-3">
                        <i class="fas fa-van-shuttle me-2"></i>Explore Our Vans
                    </a>
                </div>
            </div>

            <!-- About Image -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="about-image position-relative">
                    <div class="image-main rounded-4 overflow-hidden shadow-lg">
                        <img src="https://thumbs.dreamstime.com/b/rear-view-person-using-navigation-system-close-up-young-couple-looking-digital-map-gps-their-car-234995315.jpg"
                             alt="FS TRAVELS Team" class="img-fluid">
                    </div>
                    <div class="floating-card card border-0 shadow-sm position-absolute top-0 start-0 bg-white rounded-3 p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-award text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Award Winning</h6>
                                <p class="text-muted small mb-0">Best Van Service 2023</p>
                            </div>
                        </div>
                    </div>
                    <div class="floating-card card border-0 shadow-sm position-absolute bottom-0 end-0 bg-white rounded-3 p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-success rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Expert Team</h6>
                                <p class="text-muted small mb-0">Professional Drivers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Services Section -->
<section id="services" class="services-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-dark mb-3">Our Services</h2>
            <p class="lead text-muted">Comprehensive van rental solutions for all your travel needs</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="service-card card border-0 shadow-sm h-100 text-center rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="service-icon bg-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-plane text-white fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Airport Transfers</h5>
                        <p class="text-muted mb-0">
                            Reliable airport pickup and drop-off services with professional drivers
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-card card border-0 shadow-sm h-100 text-center rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="service-icon bg-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-users text-white fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Group Tours</h5>
                        <p class="text-muted mb-0">
                            Comfortable group transportation for tours, events, and special occasions
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="service-card card border-0 shadow-sm h-100 text-center rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="service-icon bg-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase text-white fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Corporate Travel</h5>
                        <p class="text-muted mb-0">
                            Professional transportation solutions for business meetings and corporate events
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="service-card card border-0 shadow-sm h-100 text-center rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="service-icon bg-info rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-graduation-cap text-white fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">School Transport</h5>
                        <p class="text-muted mb-0">
                            Safe and reliable transportation services for educational institutions
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <a href="#vans" class="btn btn-primary btn-lg fw-semibold px-5 py-3">
                    <i class="fas fa-calendar-plus me-2"></i>Book Your Service Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section id="why-choose-us" class="why-choose-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-dark mb-3">Why Choose FS TRAVELS</h2>
            <p class="lead text-muted">Experience the difference with our premium van rental services</p>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-4" data-aos="fade-right">
                <div class="why-choose-image position-relative">
                    <div class="image-main rounded-4 overflow-hidden shadow-lg">
                        <img src="https://wecanmag.com/wp-content/uploads/2023/10/pexels-nubia-navarro-nubikini-386009-scaled.jpg'"
                             alt="Why Choose FS TRAVELS" class="img-fluid">
                    </div>

                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="why-choose-content">
                    <div class="benefits-list">
                        <div class="benefit-item d-flex mb-4">
                            <div class="benefit-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-4 flex-shrink-0">
                                <i class="fas fa-shield-alt text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2">Safety Guaranteed</h5>
                                <p class="text-muted mb-0">
                                    All our vans undergo regular safety inspections and maintenance to ensure your journey is always secure.
                                </p>
                            </div>
                        </div>

                        <div class="benefit-item d-flex mb-4">
                            <div class="benefit-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-4 flex-shrink-0">
                                <i class="fas fa-clock text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2">24/7 Availability</h5>
                                <p class="text-muted mb-0">
                                    We're available round the clock to serve your transportation needs, anytime, anywhere.
                                </p>
                            </div>
                        </div>

                        <div class="benefit-item d-flex mb-4">
                            <div class="benefit-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-4 flex-shrink-0">
                                <i class="fas fa-tag text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2">Competitive Pricing</h5>
                                <p class="text-muted mb-0">
                                    Get premium quality service at affordable rates with no hidden charges.
                                </p>
                            </div>
                        </div>

                        <div class="benefit-item d-flex">
                            <div class="benefit-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-4 flex-shrink-0">
                                <i class="fas fa-user-tie text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2">Professional Drivers</h5>
                                <p class="text-muted mb-0">
                                    Our experienced and courteous drivers ensure a comfortable and pleasant journey.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact & Location Section -->
<section id="contact" class="contact-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-dark mb-3">Contact & Location</h2>
            <p class="lead text-muted">Get in touch with us or visit our location</p>
        </div>

        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-4 mb-4" data-aos="fade-right">
                <div class="contact-info card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white py-4">
                        <h4 class="mb-0 fw-semibold text-center">
                            <i class="fas fa-headset me-2"></i>Contact Information
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Our Location</h6>
                                <p class="text-muted mb-0">60, Star Road, Periyaneelavanai-01</p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Phone Numbers</h6>
                                <p class="text-muted mb-1">0756799873</p>
                                <p class="text-muted mb-0">0771363733</p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Email Address</h6>
                                <p class="text-muted mb-0">fstravels@gmail.com</p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-start">
                            <div class="contact-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Business Hours</h6>
                                <p class="text-muted mb-1">Monday - Sunday: 24/7</p>
                                <p class="text-muted mb-0">Emergency Support: Always Available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-form card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white py-4">
                        <h4 class="mb-0 fw-semibold text-center">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="contactForm">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" placeholder="Enter your name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" placeholder="Enter your email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-phone text-muted"></i>
                                    </span>
                                    <input type="tel" class="form-control border-start-0" placeholder="Enter your phone number">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Message</label>
                                <textarea class="form-control" rows="4" placeholder="Enter your message" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-semibold py-3">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Location Map -->
            <div class="col-lg-4 mb-4" data-aos="fade-left" data-aos-delay="200">
                <div class="location-map card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white py-4">
                        <h4 class="mb-0 fw-semibold text-center">
                            <i class="fas fa-map me-2"></i>Our Location
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="map-container position-relative">
                            <!-- Static Map Image -->
                            <img src="https://media.istockphoto.com/id/1308342065/vector/folded-location-map-with-marker-city-map-with-pin-pointer-gps-navigation-map-with-city.jpg?s=612x612&w=0&k=20&c=E9DP4dIwSdwaveNwcYU2LzBeKuBoKLa7nsTxTWDHObw=" class="img-fluid w-100"
                                 onerror="this.src='https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'">
                            <div class="map-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                <div class="location-info bg-white rounded-3 p-4 text-center shadow-lg">
                                    <i class="fas fa-map-marker-alt text-primary fa-2x mb-3"></i>
                                    <h6 class="fw-bold text-dark mb-2">FS TRAVELS</h6>
                                    <p class="text-muted small mb-0">60, Star Road<br>Periyaneelavanai-01</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Footer Section -->
<footer class="footer bg-dark text-light pt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand d-flex align-items-center mb-3">
                    <i class="fas fa-van-shuttle fa-2x text-primary me-2"></i>
                    <h4 class="mb-0 fw-bold">FS TRAVELS</h4>
                </div>
                <p class="text-light mb-3">
                    Your trusted partner for comfortable and reliable van rentals.
                    We provide top-quality vehicles for all your transportation needs with 24/7 customer support.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
<div class="col-lg-2 col-md-6">
    <h5 class="fw-bold mb-3 text-white">Quick Links</h5>
    <ul class="list-unstyled">
        <li class="mb-2">
            <a href="{{ route('home') }}" class="footer-link">
                <i class="fas fa-home me-2"></i>Home
            </a>
        </li>
        <li class="mb-2">
            <a href="#vans" class="footer-link">
                <i class="fas fa-van-shuttle me-2"></i>Available Vans
            </a>
        </li>
        <li class="mb-2">
            <a href="#services" class="footer-link">
                <i class="fas fa-concierge-bell me-2"></i>Our Services
            </a>
        </li>
        <li class="mb-2">
            <a href="#why-choose-us" class="footer-link">
                <i class="fas fa-star me-2"></i>Why Choose Us
            </a>
        </li>
        <li class="mb-2">
            <a href="#contact" class="footer-link">
                <i class="fas fa-phone me-2"></i>Contact Us
            </a>
        </li>
        <li>
            <a href="#about" class="footer-link">
                <i class="fas fa-info-circle me-2"></i>About Us
            </a>
        </li>
    </ul>
</div>
            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3 text-white">Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-map-marker-alt text-primary me-2 mt-1"></i>
                        <span class="text-light">60, Star Road, Periyaneelavanai-01</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <div>
                            <span class="text-light d-block">0756799873</span>
                            <span class="text-light d-block">0771363733</span>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <span class="text-light">fstravels@gmail.com</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <span class="text-light">24/7 Customer Support</span>
                    </li>
                </ul>
            </div>

            <!-- Newsletter & Payment -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3 text-white">Stay Updated</h5>
                <p class="text-light mb-3">Subscribe for updates on new vans and special offers.</p>
                <form class="newsletter-form mb-4">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email" required>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>

                <div class="payment-methods">
                    <p class="text-light small mb-2">We Accept:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="payment-icon">
                            <i class="fab fa-cc-visa"></i>
                        </div>
                        <div class="payment-icon">
                            <i class="fab fa-cc-mastercard"></i>
                        </div>
                        <div class="payment-icon">
                            <i class="fab fa-cc-paypal"></i>
                        </div>
                        <div class="payment-icon">
                            <i class="fab fa-cc-amex"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4 bg-light opacity-25">

        <!-- Copyright -->
        <div class="row align-items-center py-3">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-light">
                    &copy; 2024 <strong>FS TRAVELS</strong>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 text-light">
                    Made with <i class="fas fa-heart text-danger"></i> for travelers
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Custom Styles -->
<style>
:root {
    --primary: #4361ee;
    --secondary: #010005;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark: #1f2937;
    --light: #f8fafc;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.floating-animation {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Van Cards */
.van-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.van-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.van-image-container {
    height: 220px;
    overflow: hidden;
}

.van-image {
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.van-card:hover .van-image {
    transform: scale(1.1);
}

.van-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.3));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.van-card:hover .van-overlay {
    opacity: 1;
}

/* Services Section Styles */
.service-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.service-icon {
    width: 80px;
    height: 80px;
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1);
}

/* Why Choose Us Styles */
.why-choose-image {
    padding: 20px;
}

.experience-badge {
    transform: translate(20px, -20px);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: translate(20px, -20px) scale(1); }
    50% { transform: translate(20px, -20px) scale(1.05); }
}

.benefit-icon {
    width: 60px;
    height: 60px;
}

.benefit-item {
    transition: all 0.3s ease;
}

.benefit-item:hover {
    transform: translateX(10px);
}

/* Contact Section Styles */
.contact-icon {
    width: 40px;
    height: 40px;
}

.contact-item {
    transition: all 0.3s ease;
}

.contact-item:hover {
    transform: translateX(5px);
}

.map-container {
    height: 300px;
    overflow: hidden;
}

.map-overlay {
    background: rgba(67, 97, 238, 0.1);
    opacity: 0;
    transition: all 0.3s ease;
}

.map-container:hover .map-overlay {
    opacity: 1;
}

.location-info {
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.map-container:hover .location-info {
    transform: scale(1);
}

/* Form Styles */
.contact-form .form-control {
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.contact-form .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
}

/* Responsive Design for New Sections */
@media (max-width: 768px) {
    .service-icon {
        width: 70px;
        height: 70px;
    }

    .benefit-icon {
        width: 50px;
        height: 50px;
    }

    .experience-badge {
        position: relative !important;
        transform: none !important;
        margin-top: 1rem;
    }

    .contact-item:hover {
        transform: none;
    }

    .map-overlay {
        opacity: 1;
    }

    .location-info {
        transform: scale(0.8);
    }
}

/* Buttons */
.btn-hover-grow {
    transition: all 0.3s ease;
}

.btn-hover-grow:hover {
    transform: scale(1.05);
}

/* Badges */
.badge-glow {
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from {
        box-shadow: 0 0 5px rgba(16, 185, 129, 0.5);
    }
    to {
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.8);
    }
}

/* New Booking Highlight */
.new-booking-highlight {
    border: 2px solid var(--success) !important;
    animation: pulse-border 2s ease-in-out infinite;
}

@keyframes pulse-border {
    0%, 100% { border-color: var(--success); }
    50% { border-color: rgba(16, 185, 129, 0.5); }
}

/* Table Styles */
.booking-row {
    transition: background-color 0.2s ease;
}

.booking-row:hover {
    background-color: #f8fafc;
}

/* Section Headers */
.section-header {
    position: relative;
}

.section-header::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 2px;
}

/* Empty States */
.empty-state {
    padding: 3rem 2rem;
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important;
}

/* About Section Styles */
.about-section {
    position: relative;
    overflow: hidden;
}

.about-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234361ee' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.feature-icon {
    width: 50px;
    height: 50px;
    flex-shrink: 0;
}

.stats-section .stat-item {
    position: relative;
}

.stats-section .stat-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 1px;
    height: 40px;
    background: #e5e7eb;
}

.about-image {
    padding: 20px;
}

.image-main {
    position: relative;
    z-index: 1;
}

.floating-card {
    z-index: 2;
    animation: float-card 4s ease-in-out infinite;
    width: 200px;
}

.floating-card:first-child {
    animation-delay: 0s;
}

.floating-card:last-child {
    animation-delay: 2s;
}

@keyframes float-card {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

/* Footer Styles */
.footer {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
    border-top: 1px solid #333;
}

.footer-link {
    color: #b0b7c3 !important;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    padding: 0.25rem 0;
}

.footer-link:hover {
    color: var(--primary) !important;
    transform: translateX(5px);
}

.social-links {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #b0b7c3 !important;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--primary);
    color: white !important;
    transform: translateY(-3px);
}

.payment-methods {
    margin-top: 1.5rem;
}

.payment-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 30px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 6px;
    color: #b0b7c3;
    font-size: 1.25rem;
    transition: all 0.3s ease;
}

.payment-icon:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    transform: translateY(-2px);
}

.newsletter-form .form-control {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid #444;
    color: white;
}

.newsletter-form .form-control:focus {
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--primary);
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
}

.newsletter-form .form-control::placeholder {
    color: #b0b7c3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section .display-4 {
        font-size: 2.5rem;
    }

    .van-image-container {
        height: 180px;
    }

    .table-responsive {
        font-size: 0.875rem;
    }

    .footer {
        text-align: center;
    }

    .footer-link {
        justify-content: center;
    }

    .social-links {
        justify-content: center;
    }

    .stats-section .stat-item:not(:last-child)::after {
        display: none;
    }

    .floating-card {
        position: relative !important;
        margin-bottom: 1rem;
        width: 100%;
    }

    .about-image {
        padding: 0;
        margin-top: 2rem;
    }
}

/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}

/* AOS Animation Overrides */
[data-aos] {
    pointer-events: none;
}
[data-aos].aos-animate {
    pointer-events: auto;
}
</style>

<!-- Additional Libraries -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Add smooth scrolling to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced cancel booking functionality
        document.querySelectorAll('.cancel-booking-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const bookingId = this.getAttribute('data-booking-id');
                const form = this.closest('form');

                // SweetAlert2 confirmation
                Swal.fire({
                    title: 'Cancel Booking?',
                    text: "Are you sure you want to cancel this booking? This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Canceling...';
                        this.disabled = true;

                        // Submit the form
                        form.submit();
                    }
                });
            });
        });

        // Newsletter form handling
        document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;

            // Simulate newsletter subscription
            const btn = this.querySelector('button');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');

                Swal.fire({
                    title: 'Subscribed!',
                    text: 'Thank you for subscribing to our newsletter.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                    this.reset();
                }, 2000);
            }, 1500);
        });

        // Contact Form Handling
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;

            // Simulate form submission
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Message Sent!';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');

                Swal.fire({
                    title: 'Message Sent!',
                    text: 'Thank you for contacting us. We will get back to you soon.',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });

                // Reset form and button
                setTimeout(() => {
                    this.reset();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');
                }, 3000);
            }, 2000);
        });
    });
</script>

<!-- Include SweetAlert2 for beautiful confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
