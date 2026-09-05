<?php

session_start();
require_once "./components/navbar.php";
require_once "./components/footer.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OnlineStore - Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        .py-8 {
            padding-top: 8rem !important;
            padding-bottom: 8rem !important;
        }
        .mb-6 {
            margin-bottom: 6rem !important;
        }
        .shadow-sm {
            box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
        }
        .rounded-4 {
            border-radius: 1rem !important;
        }
        .btn-lg {
            font-size: 1.1rem !important;
            padding: 0.75rem 1.25rem !important;
        }
    </style>
</head>
<body>
    <main>
        <?php render_navbar(['active' => 'contact']); ?>
        
        <section class="py-8" style="background: #f8f9fa;">
            <div class="container">
                <!-- Section Header -->
                <div class="text-center mb-6">
                    <h2 class="fw-bold display-4">Contact Us 📬</h2>
                    <p class="text-secondary fs-5 mx-auto" style="max-width: 700px;">
                        Have questions or need support? Reach out to us and we’ll get back to you as soon as possible!
                    </p>
                </div>

                <div class="row g-5 align-items-center">
                    <!-- Contact Info -->
                    <div class="col-md-6">
                        <div class="p-4 bg-white shadow-sm rounded-4 h-100">
                            <h5 class="fw-bold mb-4">Get in Touch</h5>
                            <p>📧 <strong>Email:</strong> support@onlinestore.com</p>
                            <p>📞 <strong>Phone:</strong> +123 456 789</p>
                            <p>📍 <strong>Address:</strong> Main Street, City</p>
                            <p class="mt-4 text-muted">
                                We’re here to help you with any questions, feedback, or support requests.
                            </p>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-md-6">
                        <div class="p-4 bg-white shadow-sm rounded-4">
                            <form>
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg" placeholder="Your Name">
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control form-control-lg" placeholder="Your Email">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control form-control-lg" rows="5" placeholder="Your Message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">Send Message ✉️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <?php render_footer(); ?>
</body>
</html>
