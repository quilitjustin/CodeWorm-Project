<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.meta')
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/splash.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">CodeWorm</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public_profile.index') }}">Portfolio</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="editable-content text-white font-weight-bold"></h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="editable-content text-white-75 mb-5">Start Bootstrap
                        can help you build better websites
                        using the Bootstrap
                        framework! Just download a theme and start customizing, no strings attached!</p>
                    <a class="btn btn-primary btn-xl" href="/login">Play now!</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="editable-content text-white mt-0">We've got what
                        you need!</h2>
                    <hr class="divider divider-light" />
                    <p class="editable-content text-white-75 mb-4">Start Bootstrap
                        has everything you need to get your
                        new website up and
                        running in no time! Choose one of our open source, free to download, and easy to use themes! No
                        strings attached!</p>
                    <a class="btn btn-light btn-xl" href="#services">Get Started!</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="editable-content text-center mt-0">At Your Service</h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                        <h3 class="editable-content h4 mb-2">Sturdy
                            Themes</h3>
                        <p class="editable-content text-muted mb-0">Our themes
                            are updated regularly to keep them bug
                            free!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>
                        <h3 class="editable-content h4 mb-2">Up to Date
                        </h3>
                        <p class="editable-content text-muted mb-0">All
                            dependencies are kept current to keep things
                            fresh.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div>
                        <h3 class="editable-content h4 mb-2">Ready to
                            Publish</h3>
                        <p class="editable-content text-muted mb-0">You can use
                            this design as is, or you can make
                            changes!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>
                        <h3 class="editable-content h4 mb-2">Made with
                            Love</h3>
                        <p class="editable-content text-muted mb-0">Is it
                            really open source if it's not made with
                            love?</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio-->
    <div id="portfolio">
        <div class="container-fluid p-0 bg-dark">
            <div class="row g-0 justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="{{ asset('assets/img/portfolio/fullsize/1.jpg') }}"
                        title="Project Name">
                        <img class="img-fluid" src="{{ asset('assets/img/portfolio/thumbnails/1.jpg') }}"
                            alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Category</div>
                            <div class="project-name">Project Name</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="{{ asset('assets/img/portfolio/fullsize/2.jpg') }}"
                        title="Project Name">
                        <img class="img-fluid" src="{{ asset('assets/img/portfolio/thumbnails/2.jpg') }}"
                            alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Category</div>
                            <div class="project-name">Project Name</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="{{ asset('assets/img/portfolio/fullsize/3.jpg') }}"
                        title="Project Name">
                        <img class="img-fluid" src="{{ asset('assets/img/portfolio/thumbnails/3.jpg') }}"
                            alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Category</div>
                            <div class="project-name">Project Name</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="{{ asset('assets/img/portfolio/fullsize/4.jpg') }}"
                        title="Project Name">
                        <img class="img-fluid" src="{{ asset('assets/img/portfolio/thumbnails/4.jpg') }}"
                            alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Category</div>
                            <div class="project-name">Project Name</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="{{ asset('assets/img/portfolio/fullsize/5.jpg') }}"
                        title="Project Name">
                        <img class="img-fluid" src="{{ asset('assets/img/portfolio/thumbnails/5.jpg') }}"
                            alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Category</div>
                            <div class="project-name">Project Name</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="{{ asset('assets/img/portfolio/fullsize/6.jpg') }}"
                        title="Project Name">
                        <img class="img-fluid" src="{{ asset('assets/img/portfolio/thumbnails/6.jpg') }}"
                            alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Category</div>
                            <div class="project-name">Project Name</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to action-->
    <section class="page-section bg-dark text-white">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="editable-content mb-4">Free Download at Start Bootstrap!</h2>
            <a class="btn btn-light btn-xl" href="#">Download Now!</a>
        </div>
    </section>
    <!-- Contact-->
    <section class="page-section" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="editable-content mt-0">Let's Get In
                        Touch!</h2>
                    <hr class="divider" />
                    <p class="editable-content text-muted mb-5">Ready to start
                        your next project with us? Send us a messages and we will
                        get back to you as soon as possible!</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <form id="contact-form" action="{{ route('web.inquiries.store') }}" method="POST">
                        @csrf
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" type="text" name="name"
                                placeholder="Enter your name..." data-sb-validations="required" />
                            <label for="name">Full name</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" type="email" name="email"
                                placeholder="name@example.com" data-sb-validations="required,email" />
                            <label for="email">Email address</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.
                            </div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                        </div>
                        <!-- Phone number input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="phone" name="phone" placeholder="09123456789"
                                data-sb-validations="required" />
                            <label for="phone">Phone number</label>
                            <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is
                                required.</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" type="text" name="message"
                                placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                            <label for="message">Message</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <ul id="errors">

                            </ul>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid"><button class="btn btn-primary btn-xl" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <i class="bi-phone fs-2 mb-3 text-muted"></i>
                    <p class="editable-content">+1
                        (555) 123-4567</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to action-->
    <section id="inquiry-success" class="page-section bg-success text-white" hidden>
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4">Submitted Successfully</h2>
            <p class="text-light">We would send a response to you as soon as possible. Thank you!</p>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted"><strong>Copyright &copy; 2023 <a href="/">CodeWorm PH,
                        Inc</a>.</strong>
                All rights reserved.</div>
        </div>
    </footer>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/splash.js') }}"></script>

    <script>
        const content = $(".editable-content");

        let items = {!! $content !!};

        for (i = 0; i < content.length; i++) {
            $(content[i]).text(items[i]["text"]);
        }
        
        const contactForm = $("#contact-form");

        contactForm.submit(function(e) {
            e.preventDefault();
            const route = $(this).attr("action");
            const data = $(this).serialize();
            $.post({
                url: route,
                data: data,
                success: function(response) {
                    console.log(response);
                    contactForm.prop("hidden", true);
                    $("#inquiry-success").prop("hidden", false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // validation error during request
                    if (jqXHR.status === 422) {
                        const errors = jqXHR.responseJSON.errors;
                        const errField = $("#errors");
                        errField.empty();
                        $.each(errors, function(key, value) {
                            errField.append("<li class='text-danger''>" + value +
                                "</li>");
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
