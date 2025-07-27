    <section style="margin-bottom: 70px;">
        <!-- AOS CSS -->
        <style>
            .text-heading-1 {
                font-size: 1.2rem !important;
            }

            .text-heading-2 {
                font-size: .8rem !important;
            }

            @media (min-width: 768px) {}

            @media (min-width: 992px) {
                .text-heading-1 {
                    font-size: 1.2rem !important;
                }

                .text-heading-2 {
                    font-size: .8rem !important;
                }
            }

            @media (min-width: 1200px) {
                .w-xl-20 {
                    width: 20% !important;
                }

                .text-heading-1 {
                    font-size: 1.2rem !important;
                }

                .text-heading-2 {
                    font-size: .8rem !important;
                }
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
        <div class="container-fluid mt-80">

            <div class="row justify-content-center g-5 px-20 py-5" data-aos="fade-up" data-aos-duration="1000" id="aboutUsContainer"></div>

            <script>
                const aboutUsSections = [{
                        title1: "Who We Are",
                        title2: "Creative team from Lanka",
                        image: "custom-section/img/man-with-beer-svgrepo-com.svg",
                        href: "file-1.php"
                    },
                    {
                        title1: "What We Do",
                        title2: "Building online store platforms",
                        image: "custom-section/img/business-person-to-guide-left-hand-svgrepo-com.svg",
                        href: "file-2.php"
                    },
                    {
                        title1: "Why Choose Us",
                        title2: "Trusted by locals, built global",
                        image: "custom-section/img/man-with-computer-and-headset-svgrepo-com.svg",
                        href: "file-4.php"
                    },
                    {
                        title1: "Our Mission",
                        title2: "Empowering Lankan businesses",
                        image: "custom-section/img/man-with-hand-on-chin-svgrepo-com.svg",
                        href: "file-3.php"
                    },
                    {
                        title1: "Our Vision",
                        title2: "Smart commerce for everyone",
                        image: "custom-section/img/man-with-magnifying-glass-svgrepo-com.svg",
                        href: "file-5.php"
                    }
                ];

                const aboutUsContainer = document.getElementById("aboutUsContainer");

                aboutUsSections.forEach(section => {
                    aboutUsContainer.innerHTML += `
      <div class="col-6 col-sm-6 col-md-4 col-lg-3 w-xl-20">
        <a href="${section.href}" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm hover-pop text-center c-card p-5">
            <div class="row">
              <div class="col-12 d-flex justify-content-center p-5">
                <img src="${section.image}" width="100px" style="margin-top: 20px;" alt="${section.title1}">
              </div>
            </div>
            <div class="card-body">
              <span class="text-heading text-sm mb-8">${section.title1}</span>
              <h6 class="mb-0 text-heading-1">${section.title2}</h6>
              <div class="col-12">
              <a href="${section.href}" class="d-inline-flex align-items-center text-heading-2 mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                View More
                <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
              </a>
              </div>
            </div>
          </div>
        </a>
      </div>
    `;
                });
            </script>

        </div>

        <!-- AOS JS -->
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

        <!-- Hover Animation CSS -->
        <style>
            .hover-pop {
                transition: transform 0.3s ease;
            }

            .hover-pop:hover {
                transform: scale(1.05);
            }

            .c-card {
                background-image: url("assets/images/bgbgbg.jpg") !important;
                background-position: center !important;
                background-size: cover !important;
                /* background-color: #CAD6FF !important; */
                border-radius: 15px !important;
            }
        </style>

    </section>