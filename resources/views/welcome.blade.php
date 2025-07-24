<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Barangay System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- title-logo -->
    <link rel="shortcut icon" href="{{ URL::to('admin_assets/images/logo-left.png') }}">
    <link rel="shortcut icon" href="{{ URL::to('admin_assets/images/logo-left.png') }}" type="image/x-icon">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>

<x-landing-modal.global-modal />

<div class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Header -->
    <header class="w-full shadow-sm bg-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-blue-800">BarangaySystem</div>
            @if (Route::has('login'))
                <nav class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-1.5 border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] rounded">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-1.5 border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] rounded">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-5 py-1.5 border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] rounded">
                                Register
                            </a>
                        @endif
                    @endauth
                    <button onclick="window.openTrackingModal()"
                        class="px-5 py-1.5 border border-[#19140035] hover:border-[#1915014a] rounded text-[#1b1b18]">
                        Track My Request
                    </button>
                </nav>
            @endif
        </div>
    </header>

    <!-- Landing Page -->
    <div class="flex-grow bg-white text-gray-800 font-sans">

        <!-- Hero Section -->
        <section class="bg-blue-50 py-20 text-center">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-blue-800">Modern Barangay Management System</h2>
                <p class="text-lg mb-8 text-gray-600">
                    Empowering your community with digital solutions — certificates, clearances, ID requests, and more.
                </p>
                <a href="#services"
                    class="bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">Explore
                    Services</a>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="about-us" class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-blue-800 mb-6">About Us</h2>
                <p class="text-gray-700 text-lg mb-8">
                    Our Barangay System is a digital platform developed to streamline community services, reduce manual
                    paperwork,
                    and provide a more efficient experience for both barangay officials and residents. From clearances
                    to resident
                    registration and permits — everything is just a few clicks away.
                </p>
                <div class="grid md:grid-cols-3 gap-8 text-left">
                    <div class="p-6 bg-blue-50 rounded-lg shadow hover:shadow-md transition">
                        <h4 class="text-xl font-semibold text-blue-700 mb-2">Mission</h4>
                        <p class="text-gray-600 text-sm">
                            To empower local barangays through accessible and reliable digital services that improve
                            day-to-day operations and resident satisfaction.
                        </p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-lg shadow hover:shadow-md transition">
                        <h4 class="text-xl font-semibold text-blue-700 mb-2">Vision</h4>
                        <p class="text-gray-600 text-sm">
                            To be the leading barangay e-governance platform in the Philippines, connecting citizens and
                            officials with transparency and ease.
                        </p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-lg shadow hover:shadow-md transition">
                        <h4 class="text-xl font-semibold text-blue-700 mb-2">Core Values</h4>
                        <ul class="list-disc list-inside text-gray-600 text-sm space-y-1">
                            <li>Transparency</li>
                            <li>Efficiency</li>
                            <li>Accessibility</li>
                            <li>Community-First Approach</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold text-center text-blue-800 mb-10">Our Services</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="border rounded-lg p-6 hover:shadow-lg">
                        <h4 class="text-xl font-semibold mb-2">Barangay Residence</h4>
                        <p class="text-gray-600">Request a barangay residence certificate with ease through our digital form.</p>
                    </div>
                    <div class="border rounded-lg p-6 hover:shadow-lg">
                        <h4 class="text-xl font-semibold mb-2">Barangay ID</h4>
                        <p class="text-gray-600">Apply for an official Barangay ID with photo and QR code for verification.</p>
                    </div>
                    <div class="border rounded-lg p-6 hover:shadow-lg">
                        <h4 class="text-xl font-semibold mb-2">Barangay Indigency</h4>
                        <p class="text-gray-600">Get your certificate of indigency for school, work, or medical assistance.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Barangay Cards -->
        <section id="services" class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold text-center text-blue-800 mb-10">Popular Barangay Requests</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    <!-- Indigency -->
                    <div class="relative bg-white rounded-lg shadow-md hover:shadow-xl pt-12 pb-6 px-4 text-center">
                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-blue-100 p-4 rounded-full shadow-md">
                            <i class="bi bi-person-exclamation text-blue-700 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold mb-2 mt-2">Indigency Certificate</h4>
                        <p class="text-gray-600 text-sm">Proof of indigency for scholarship or medical use.</p>
                        <button onclick="openIndigencyModal('IndigencyModal')" class="mt-3 w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Request Now</button>
                    </div>

                    <!-- Barangay ID -->
                    <div class="relative bg-white rounded-lg shadow-md hover:shadow-xl pt-12 pb-6 px-4 text-center">
                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-blue-100 p-4 rounded-full shadow-md">
                            <i class="bi bi-person-badge text-blue-700 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold mb-2 mt-2">Barangay ID</h4>
                        <p class="text-gray-600 text-sm">Apply for or renew your official Barangay ID.</p>
                        <button onclick="openBarangayIdModal('barangayIdModal')" class="mt-3 w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Apply Now</button>
                    </div>

                    <!-- Barangay Residence -->
                    <div class="relative bg-white rounded-lg shadow-md hover:shadow-xl pt-12 pb-6 px-4 text-center">
                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-blue-100 p-4 rounded-full shadow-md">
                            <i class="bi bi-house-door text-blue-700 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold mb-2 mt-2">Barangay Residence</h4>
                        <p class="text-gray-600 text-sm">Get your barangay residency certificate quickly and easily.</p>
                        <button onclick="openResidenceModal('residencyModal')" class="mt-3 w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Get Certificate</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-10 bg-white">
            <div class="max-w-5xl mx-auto px-4 text-center">
                <h3 class="text-2xl font-bold text-blue-800 mb-6">What Residents Say</h3>
                <div class="relative">
                    <!-- Left Button -->
                    <button onclick="scrollCarousel(-1)"
                        class="absolute left-2 top-1/2 transform -translate-y-1/2 z-10
                           w-10 h-10 rounded-full bg-blue-700 text-white text-sm
                           flex items-center justify-center shadow hover:bg-blue-600 transition">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <!-- Scrollable Carousel -->
                    <div id="feedback-carousel"
                        class="flex gap-4 overflow-x-auto scroll-smooth scrollbar-hide px-6 py-2">
                        <!-- Cards will be inserted here by JavaScript -->
                    </div>

                    <!-- Right Button -->
                    <button onclick="scrollCarousel(1)"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 z-10 bg-blue-700 text-white text-sm
                           w-10 h-10 rounded-full flex items-center justify-center shadow hover:bg-blue-600 transition">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                <!-- Add Feedback Button -->
                <div class="text-center mt-6">
                    <button onclick="toggleFeedbackModal()"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-md shadow-md transition">
                        Add Feedback
                    </button>
                </div>
            </div>
        </section>

        <!-- Feedback Modal -->
        <div id="feedbackModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
            <div id="feedbackModalContent"
                class="bg-white w-full max-w-lg mx-auto rounded-lg shadow-lg p-6 relative transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
                <!-- Close Button -->
                <button onclick="toggleFeedbackModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold">
                    &times;
                </button>

                <h3 class="text-xl font-bold text-blue-800 mb-4 text-center">Leave Your Feedback</h3>

                <form id="feedback-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="modal-name" class="block text-sm font-medium text-gray-700">Your Name</label>
                        <input type="text" name="name" id="modal-name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>

                    <div>
                        <label for="modal-message" class="block text-sm font-medium text-gray-700">Your
                            Feedback</label>
                        <textarea name="message" id="modal-message" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-md shadow-sm transition text-sm">
                            Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-blue-700 text-white py-8">
            <div
                class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-start text-sm space-y-6 md:space-y-0">
                <!-- Left: Branding -->
                <div>
                    <h4 class="text-lg font-semibold mb-2">BarangaySystem</h4>
                    <p>&copy; 2025 All rights reserved.</p>
                </div>

                <!-- Right: Contact Info -->
                <div>
                    <h4 class="font-semibold mb-2">Contact</h4>
                    <p>Email: ivanschoolworks26@gmail.com</p>
                    <p>Phone: +63 953 579 9859</p>
                </div>
            </div>
        </footer>
    </div>
</div>

</html>

<x-back-to-top />
<!-- Modal Toggle Script -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    let isModalVisible = false;

    // Global Modal Control
    window.openModal = function(id) {
        document.getElementById(id)?.classList.remove('hidden');
    };

    // Global Closed Modal Control
    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        const form = modal.querySelector('form');
        if (form) form.reset();
    };

    // Toast Notification Function
    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(toastContainer);
        }

        // Clear existing toast
        while (toastContainer.firstChild) {
            toastContainer.removeChild(toastContainer.firstChild);
        }

        const toast = document.createElement('div');
        toast.className = `flex items-center px-4 py-3 rounded-lg shadow-lg max-w-xs transition-opacity duration-300 ${
            type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        }`;

        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2 ${
                    type === 'success' ? 'text-green-500' : 'text-red-500'
                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'success'
                            ? 'M9 12l2 2l4 -4m7 8a9 9 0 1 1 -18 0a9 9 0 0 1 18 0z'
                            : 'M12 9v2m0 4h.01m6.938 4h-13.856c-1.344 0-2.402-1.066-2.122-2.387l1.721-9.215A2 2 0 0 1 6.667 4h10.666a2 2 0 0 1 1.957 2.398l-1.721 9.215c-.28 1.321-1.338 2.387-2.682 2.387z'
                    }" />
                </svg>
                <span class="text-black">${message}</span>
            </div>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            toast.addEventListener('transitionend', () => toast.remove());
            toast.remove();
        }, 2000);
    }

    function toggleFeedbackModal() {
        const modal = document.getElementById('feedbackModal');
        const modalContent = document.getElementById('feedbackModalContent');

        if (!isModalVisible) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            // Hide animation
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            // After animation duration, hide the modal
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        isModalVisible = !isModalVisible;
    }

    // Globally exposed function for modal toggle
    window.toggleFeedbackModal = function() {
        const modal = document.getElementById('feedbackModal');
        const modalContent = document.getElementById('feedbackModalContent');
        const submitBtn = document.querySelector("#feedback-form button[type='submit']");

        if (modal.classList.contains('hidden')) {
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Reset submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = "Submit Feedback";
            }
        } else {
            // Hide modal
            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
    };

    // Globally exposed function for submitting feedback
    window.submitFeedback = function(e) {
        e.preventDefault();

        const name = document.getElementById("modal-name").value;
        const message = document.getElementById("modal-message").value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        const submitBtn = document.querySelector("#feedback-form button[type='submit']");
        submitBtn.disabled = true;
        submitBtn.innerText = "Submitting...";

        axios.post("/feedback", {
                name: name,
                message: message
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(function(response) {
                showToast("Thank you for your feedback!", "success");
                document.getElementById("feedback-form").reset();
                window.toggleFeedbackModal();
                window.fetchFeedback?.();

                // Optionally disable submit completely after success
                submitBtn.disabled = true;
                submitBtn.innerText = "Submitted";
            })
            .catch(function(error) {
                showToast("Something went wrong. Please try again.", "error");
                console.error(error);

                // Re-enable button if failed
                submitBtn.disabled = false;
                submitBtn.innerText = "Submit Feedback";
            });
    };

    // Attach event listener after DOM is loaded
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("feedback-form");
        if (form) {
            form.addEventListener("submit", window.submitFeedback);
        }
    });

    // Carousel
    window.scrollCarousel = function(direction) {
        const container = document.getElementById('feedback-carousel');
        const scrollAmount = 300; // Adjust scroll per click
        container.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    };

    // Declare globally first
    window.fetchFeedback = function() {
        axios.get('/getFeedback')
            .then(function(response) {
                const feedbackList = document.getElementById('feedback-carousel');
                feedbackList.innerHTML = '';

                if (response.data.length === 0) {
                    feedbackList.innerHTML =
                        '<div class="w-full flex justify-center items-center text-gray-500 min-h-[100px]">No feedback yet.</div>';
                    return;
                }

                response.data.forEach(feedback => {
                    const card = document.createElement('div');
                    card.className =
                        'min-w-[250px] max-w-xs bg-white border p-4 rounded-md shadow-sm flex-shrink-0';
                    card.innerHTML = `
                        <p class="text-gray-600 italic text-sm">"${feedback.message}"</p>
                        <p class="mt-3 text-sm font-semibold text-blue-700">- ${feedback.name}</p>
                    `;
                    feedbackList.appendChild(card);
                });
            })
            .catch(function(error) {
                console.error("Error loading feedbacks:", error);
            });
    };

    // Loaded data
    document.addEventListener("DOMContentLoaded", function() {
        window.fetchFeedback();
    });

    // Generated the barangayId refereal code
    function generateBarangayIdNumber() {
        const now = new Date();
        const datePart = now.toISOString().slice(0, 10).replace(/-/g, ''); // e.g., 20250713
        const randomPart = Math.floor(1000 + Math.random() * 9000); // 4-digit random number
        return `BRGY-${datePart}-${randomPart}`;
    }

    // Generate the barangay Indigency
    function generateIndigencyNumber() {
        const now = new Date();
        const datePart = now.toISOString().slice(0, 10).replace(/-/g, ''); // e.g., 20250713
        const randomPart = Math.floor(1000 + Math.random() * 9000); // 4-digit random number
        return `INDI-${datePart}-${randomPart}`;
    }

    // Generate the barangay residence
    function generateResidenceNumber() {
        const now = new Date();
        const datePart = now.toISOString().slice(0, 10).replace(/-/g, ''); // e.g., 20250713
        const randomPart = Math.floor(1000 + Math.random() * 9000); // 4-digit random number
        return `RESID-${datePart}-${randomPart}`;
    }

    // Modal Function
    // Open indigency Modal
    window.openIndigencyModal = function (type) {
        const modal = document.getElementById('IndigencyModal');
        modal.classList.remove('hidden');

        // 🟦 Keep referral and date generation intact
        document.getElementById('indigency_generated_number').value = generateIndigencyNumber();
        document.getElementById('date').value = new Date().toISOString().slice(0, 10);
    };

    // Handle form submission indigency with spinner
    document.getElementById('indigencyForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        const submitBtn = document.getElementById('btnSubmitIndigency');
        const spinner = document.getElementById('submitSpinner');
        const submitText = document.getElementById('submitText');

        // Show loading
        spinner.classList.remove('hidden');
        submitText.textContent = 'Submitting...';
        submitBtn.disabled = true;

        axios.post('/addIndigency', formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            showToast('Form submitted successfully!', 'success');
            closeModal('IndigencyModal');
        })
        .catch(error => {
            console.error('Submit error:', error);
            showToast('Submission failed. Please check your input.', 'error');
        })
        .finally(() => {
            // Restore button state
            spinner.classList.add('hidden');
            submitText.textContent = 'Submit';
            submitBtn.disabled = false;
        });
    });

    // Open residence Modal and set default values
    window.openResidenceModal = function (type) {
        const modal = document.getElementById('residencyModal');
        modal.classList.remove('hidden');

        // Generate certificate number
        const certificateInput = document.getElementById('certificate_number');
        if (certificateInput) {
            certificateInput.value = generateResidenceNumber();
        }

        // Set issue date (handle fallback if element doesn't exist)
        const issueDateInput = document.getElementById('issue_date');
        if (issueDateInput) {
            issueDateInput.value = new Date().toISOString().slice(0, 10);
        }
    };

    // Handle form submission with spinner
    function submitResidency(e) {
        e.preventDefault();

        const form = document.getElementById('residencyForm');
        const formData = new FormData(form);

        // Manually convert checkbox value to "1" or "0"
        const checkbox = document.getElementById('has_criminal_record');
        formData.set('has_criminal_record', checkbox && checkbox.checked ? '1' : '0');

        // Reference elements outside the form
        const submitBtn = document.getElementById('btnSubmitResidency');
        const spinner = document.getElementById('submitResidenceSpinner');
        const submitText = document.getElementById('submitText');

        // Show loading state
        spinner.classList.remove('hidden');
        submitText.textContent = 'Submitting...';
        submitBtn.disabled = true;

        // Send request to backend
        axios.post('/addResidence', formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            showToast('Form submitted successfully!', 'success');
            closeModal('residencyModal');
            form.reset(); // optional: reset form after submission
        })
        .catch(error => {
            console.error('Submit error:', error);
            showToast('Submission failed. Please check your input.', 'error');
        })
        .finally(() => {
            // Restore button state
            spinner.classList.add('hidden');
            submitText.textContent = 'Submit';
            submitBtn.disabled = false;
        });
    }

    // Open Barangay ID Modal and set default values
    window.openBarangayIdModal = function () {
        const modal = document.getElementById('barangayIdModal');
        modal.classList.remove('hidden');

        // Generate reference number
        const certificateInput = document.getElementById('barangayId_generated_number');
        if (certificateInput) {
            certificateInput.value = generateBarangayIdNumber();
        }

        // Set issue date (fallback handled if not present)
        const issueDateInput = document.getElementById('issue_date');
        if (issueDateInput) {
            issueDateInput.value = new Date().toISOString().slice(0, 10);
        }

        // Setup guardian field behavior
        window.setupGuardianReadonly();
    };

    // Enable or disable guardian input based on age
    window.setupGuardianReadonly = function () {
        const ageInput = document.getElementById('barangayId_age');
        const guardianInput = document.getElementById('barangayId_guardian');

        if (!ageInput || !guardianInput) return;

        const handleGuardianField = () => {
            const age = parseInt(ageInput.value, 10);

            if (!isNaN(age) && age >= 1 && age <= 17) {
                guardianInput.readOnly = true;
                guardianInput.required = false;
                guardianInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                guardianInput.value = '';
            } else if (!isNaN(age) && age > 17) {
                guardianInput.readOnly = false;
                guardianInput.required = true;
                guardianInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            } else {
                guardianInput.readOnly = false;
                guardianInput.required = false;
                guardianInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            }
        };

        ageInput.removeEventListener('input', handleGuardianField);
        ageInput.addEventListener('input', handleGuardianField);

        // Run once on load
        handleGuardianField();
    };

    // Handle form submit with spinner
    window.submitBarangayIdForm = function (e) {
        e.preventDefault();

        const form = document.getElementById('barangayIdForm');
        const formData = new FormData(form);

        const submitBtn = document.getElementById('btnSubmitBarangayId');
        const spinner = document.getElementById('submitBarangayIdSpinner');
        const submitText = document.getElementById('submitBarangayIdText');

        // Start loading
        spinner.classList.remove('hidden');
        submitText.textContent = 'Submitting...';
        submitBtn.disabled = true;

        axios.post('addBarangayId', formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            showToast('Form submitted successfully!', 'success');
            closeModal('barangayIdModal');
            form.reset();

            // Reset preview
            const preview = document.getElementById('imagePreview');
            if (preview) preview.classList.add('hidden');
        })
        .catch(error => {
            console.error('Submit error:', error);
            showToast('Submission failed. Please check your input.', 'error');
        })
        .finally(() => {
            spinner.classList.add('hidden');
            submitText.textContent = 'Submit';
            submitBtn.disabled = false;
        });
    };

     // Modal open/close
    window.openTrackingModal = function () {
        document.getElementById('trackingModal').classList.remove('hidden');
    };

    // Closed function of tracking data
    window.closeTrackingModal = function () {
        document.getElementById('trackingModal').classList.add('hidden');
        document.getElementById('tracking_number_input').value = '';
        document.getElementById('trackingResultContainer').classList.add('hidden');
        document.getElementById('trackingResultRow').innerHTML = '';
        document.getElementById('submitTrackingText').textContent = 'Search';
        document.getElementById('submitTrackingSpinner').classList.add('hidden');
        document.getElementById('btnSubmitTracking').disabled = false;
    };

    // Load the data of the tracking
    window.submitTrackingNumber = function (e) {
        e.preventDefault();

        const input = document.getElementById('tracking_number_input');
        const trackingNumber = input.value.trim();
        const spinner = document.getElementById('submitTrackingSpinner');
        const submitText = document.getElementById('submitTrackingText');
        const btn = document.getElementById('btnSubmitTracking');
        const resultContainer = document.getElementById('trackingResultContainer');
        const resultRow = document.getElementById('trackingResultRow');

        if (!trackingNumber) {
            showToast('Please enter a tracking number.', 'error');
            return;
        }

        // Start loading
        spinner.classList.remove('hidden');
        submitText.textContent = 'Searching...';
        btn.disabled = true;
        resultContainer.classList.add('hidden');
        resultRow.innerHTML = '';

        axios.get(`/track/${trackingNumber}`)
            .then(response => {
                const data = response.data;

                // Check if approved_by is "0" (not yet approved)
                const isApproved = data.approved_by !== "0";
                const statusText = isApproved ? 'Approved' : 'Pending';
                const description = isApproved ? 'Ready for pick up!' : 'Waiting for released!';

                resultRow.innerHTML = `
                    <tr>
                        <td class="px-4 py-2 border">${data.name || 'N/A'}</td>
                        <td class="px-4 py-2 border">${data.service_type || 'N/A'}</td>
                        <td class="px-4 py-2 border">${formatDate(data.created_at)}</td>
                        <td class="px-4 py-2 border">${description}</td>
                        <td class="px-4 py-2 border font-medium ${getStatusColor(statusText)}">
                            ${statusText}
                        </td>
                    </tr>
                `;

                resultContainer.classList.remove('hidden');
            })
            .catch(() => {
                showToast('No result found for that tracking number.', 'error');
            })
            .finally(() => {
                spinner.classList.add('hidden');
                submitText.textContent = 'Search';
                btn.disabled = false;
            });
    };

    // Color for status
    function getStatusColor(status) {
        if (status === 'Pending' || status === 0) return 'text-red-500';
        if (status === 'Approved' || status === 1) return 'text-green-600';
        return 'text-gray-500';
    }

    // Label for status
    function formatStatus(status) {
        if (status === 0 || status === 'Pending') return 'Pending';
        if (status === 1 || status === 'Approved') return 'Approved';
        return status;
    }

    // Format of date
    function formatDate(isoDate) {
        if (!isoDate) return 'N/A';
        const date = new Date(isoDate);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

</script>
