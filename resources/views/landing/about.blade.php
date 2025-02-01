<link href="{{ url('landing/assets/css/about.css') }}" rel="stylesheet">

@extends('landing.layout')



@section('title', 'About')

@section('content')
<!-- about section start -->
<div class="about_section layout_padding">
    <div class="container">
       <div class="about_section_2">
          <div class="row">
                <div class="about_taital_box">
                   <h1 class="about_taital">About Us</h1>
                   <p class="about_text">
                       San Pedro, officially the City of San Pedro (Tagalog: Lungsod ng San Pedro), is a 3rd class component city in the province of Laguna, Philippines. According to the 2020 census, it has a population of 326,001 people. It is named after its patron saint, Peter the Apostle. San Pedro has been dubbed as “dormitory town” of Metro Manila and migrants from other provinces commuting everyday through its highly efficient road and transport system. Despite being one of the smallest political units in the entire province, with a total land area of only 24.05 km2, San Pedro is the 5th most populous city (out of 6) after the cities of Calamba, Santa Rosa, Biñan and Cabuyao. The city also has the highest population density in the province of Laguna and in the whole Calabarzon region, having 14,000 people/km2. As a first class municipality, it became a component city of Laguna by virtue of RA 10420 dated March 27, 2013.
                       San Pedro is located in Region IV-A or Calabarzon. San Pedro is the boundary between Laguna and Metro Manila, so San Pedro is known as “Laguna’s Gateway to Metro Manila”. San Pedro shares boundaries with Metro Manila’s southernmost city, Muntinlupa (North) bounded with Tunasan River, Biñan (South), Dasmariñas (West), Carmona and Gen. Mariano Alvarez (Southwest) bound with San Isidro River. Its position makes San Pedro a popular suburban residential community, where many residents commute daily to Metro Manila for work.
                   </p>
                </div>
                <div class="container-2">
                    <div class="mission-box">
                        <div class="about_taital_box">
                            <h1 class="about_taital-1" >Mission</h1>
                            <p class="about_text">Deliver the highest quality of basic services to our constituents while optimizing our resources in accordance with the statutory requirements and our core values.</p>
                        </div>
                    </div>
                    <div class="vision-box">
                        <div class="about_taital_box">
                            <h1 class="about_taital-2">Vision</h1>
                            <p class="about_text">San Pedro City: A leading recognized smART City in CALABARZON by 2032.</p>
                        </div>
                    </div>
                </div>
                <div class="container-3">
                    <!-- Replace the current Core Values content in your mission-box1 div -->
                    <div class="mission-box1">
                        <div class="about_taital_box">
                            <h1 class="about_taital-3">Core Values</h1>
                            <div class="core-values-container">
                                <div class="values-grid">
                                    <div class="value"><span class="first-letter">S</span>elflessness</div>
                                    <div class="value"><span class="first-letter">P</span>rofessionalism</div>
                                    <div class="value"><span class="first-letter">C</span>ourage</div>
                                    
                                    <div class="value"><span class="first-letter">A</span>daptability</div>
                                    <div class="value"><span class="first-letter">E</span>xcellence</div>
                                    <div class="value"><span class="first-letter">I</span>nnovation</div>
                                    
                                    <div class="value"><span class="first-letter">N</span>obility</div>
                                    <div class="value"><span class="first-letter">D</span>edication</div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vision-box1">
                        <div class="about_taital_box">
                            <h1 class="about_taital-4">Tags</h1>
                            <p class="about_text">has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editorhas a more-or-less normal distribution of letters, as oppos</p>
                        </div>
                    </div>
                </div>
                <div class="readmore-container">
                    <div class="readmore_btn"><a href="#">Read More</a></div>
                </div>
          </div>
       </div>
    </div>
    <!-- about section end -->
    <!-- Footer start -->
    <footer>
        <div class = "main-footer">
            <div class="footer-container">
                <div class="left">
                    <img src="landing/assets/img/san pedro.png" alt="City of San Pedro, Laguna" class="logo">
                    <p>City of San Pedro, Laguna</p>
                    <p class = "p-graph">Is a 3rd class component city in the province of Laguna, Philippines.</p>
                    <div class="social-media1">
                        <a href="#"><img src="https://img.icons8.com/ios-filled/50/ffffff/facebook--v1.png" alt="Facebook"></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/50/ffffff/twitter--v1.png" alt="Twitter"></a>
                    </div>
                </div>
                <div class="middle">
                    <h3>BROWSE</h3>
                    <ul>
                        <li><a href="https://cityofsanpedrolaguna.gov.ph/about/">About</a></li>
                        <li><a href="https://cityofsanpedrolaguna.gov.ph/?page_id=1353">Policy Issues</a></li>
                        <li><a href="https://cityofsanpedrolaguna.gov.ph/city-services/">Services</a></li>
                        <li><a href="https://cityofsanpedrolaguna.gov.ph/forms-and-permits/">Forms and Permits</a></li>
                        <li><a href="https://cityofsanpedrolaguna.gov.ph/job-seekers/">Job Seekers</a></li>
                        <li><a href="https://cityofsanpedrolaguna.gov.ph/contact/">Talk to Us</a></li>
                    </ul>
                </div>
                <div class="right">
                    <h3>CONTACT INFORMATION</h3>
                    <p class = "right-p">4F New City Hall Bldg., Brgy. Poblacion, City of San Pedro, Laguna</p>
                    <p>Phone: 8-8082020</p>
                    <p>Email: paio.cityofsanpedro@gmail.com</p>
                </div>
            </div>
            <div class="bottom">
                <p>All Rights Reserved © 2024 City of San Pedro, Laguna</p>
            </div>
        </div>
    </footer>
    <!-- Footer end -->
</div>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@endsection

@section('styles')
<style>
    .nav a {
        margin: 0 15px;
        text-decoration: none;
        color: black;
        font-weight: bold;
    }
   
</style>
@endsection
