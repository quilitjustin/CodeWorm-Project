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
    <style>
        [contenteditable]:focus {
            outline: 0px solid transparent;
        }

        [placeholder]:empty:before {
            content: attr(placeholder);
            color: #FFFFFF;
            opacity: 0.5;
            cursor: text;
        }

        [placeholder]:empty:focus:before {
            content: "";
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">Codeworm</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
 
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead" style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('{{ asset('assets/bgim/splash.png') . '?v=' . filemtime(public_path('assets/bgim/splash.png')) }}');">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="editable-content text-white font-weight-bold" contenteditable="true"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Click to edit"
                        placeholder="Click to add title"></h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="editable-content text-white-75 mb-5" contenteditable="true" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to edit" placeholder="Click to add text">Start Bootstrap
                        can help you build better websites
                        using the Bootstrap
                        framework! Just download a theme and start customizing, no strings attached!</p>
                    <a class="btn btn-primary btn-xl" href="#">Play now!</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="editable-content text-white mt-0" contenteditable="true" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to edit" placeholder="Click to add title">We've got what
                        you need!</h2>
                    <hr class="divider divider-light" />
                    <p class="editable-content text-white-75 mb-4" contenteditable="true" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to edit" placeholder="Click to add text">Start Bootstrap
                        has everything you need to get your
                        new website up and
                        running in no time! Choose one of our open source, free to download, and easy to use themes! No
                        strings attached!</p>
                    <a class="btn btn-light btn-xl" href="#">Get Started!</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio-->
    <div id="portfolio" hidden>
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
            <h2 class="editable-content mb-4"></h2>
            <a class="btn btn-light btn-xl" href="#">Play Now!</a>
        </div>
    </section>
    <!-- Contact-->
    <section class="page-section" id="contact" hidden>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="editable-content mt-0" contenteditable="true" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to edit" placeholder="Click to add title">Let's Get In
                        Touch!</h2>
                    <hr class="divider" />
                    <p class="editable-content text-muted mb-5" contenteditable="true" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to edit" placeholder="Click to add text">Ready to start
                        your next project with us? Send us a messages and we will
                        get back to you as soon as possible!</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" type="text"
                                placeholder="Enter your name..." data-sb-validations="required" />
                            <label for="name">Full name</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" type="email" placeholder="name@example.com"
                                data-sb-validations="required,email" />
                            <label for="email">Email address</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.
                            </div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                        </div>
                        <!-- Phone number input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890"
                                data-sb-validations="required" />
                            <label for="phone">Phone number</label>
                            <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is
                                required.</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..."
                                style="height: 10rem" data-sb-validations="required"></textarea>
                            <label for="message">Message</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.
                            </div>
                        </div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />
                                <a
                                    href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center text-danger mb-3">Error sending message!</div>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid"><button class="btn btn-primary btn-xl disabled" id="submitButton"
                                type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <i class="bi-phone fs-2 mb-3 text-muted"></i>
                    <p class="editable-content" contenteditable="true" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to edit" placeholder="Click to add contact number">+1
                        (555) 123-4567</p>
                </div>
            </div>
        </div>
    </section>
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
    <div class="fixed-bottom px-2 py-3">
        <div class="d-flex justify-content-between align-items-center bg-light rounded p-2">
            <div class="text-muted" style="padding: 0">
                Currently editing the page. Version {{ $content['id'] }}
            </div>
            <div>
                <button id="cancel" class="btn btn-warning">Cancel</button>
                <button id="save-content" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/splash.js') }}"></script>

    <script>
        // From bootstrap documentation
        // https://getbootstrap.com/docs/5.1/components/tooltips/
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Ask question if they really want to leave to avoid data loss
        $(window).on("beforeunload", function(e) {
            e.preventDefault();
            e.returnValue = '';
            if (confirm("Are you sure you want to leave?")) {
                // Allow the user to leave the page
                return true;
            } else {
                // Cancel the event
                return false;
            }
        });

        $("#cancel").click(function() {
            window.history.back();
        });

        // Check if valid JSON
        function isJson(data) {
            try {
                return JSON.parse(data);
            } catch (e) {
                alert("Opps, something went wrong!");
            }
        }

        const content = $(".editable-content");

        let items = {!! $content !!};
        items = isJson(items["content"]);

        for (i = 0; i < content.length; i++) {
            $(content[i]).text(items[i]["text"]);
        }

        // Remove tooltip
        content.click(function() {
            $(this).tooltip("hide");
        });

        $("#save-content").click(function() {
            let myItems = [];
            for (i = 0; i < content.length; i++) {
                let item = {};
                item["text"] = $(content[i]).text();
                myItems.push(item);
            }
            const itemReady = JSON.stringify(myItems);
            const route = "{{ route('super.cms.splash.store') }}";
            $.post({
                url: route,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "content": itemReady,
                },
                dataType: "json",
                success: function(response) {
                    $(window).unbind("beforeunload");
                    window.location.href = "{{ route('super.cms.splash.index') }}";
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                }
            });
        });
    </script>
</body>

</html>
