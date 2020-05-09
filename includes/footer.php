

<!-- the code below is taken from the source: https://bootsnipp.com/snippets/featured/footer-using-bootstrap-4-->

<section id="footer">
    <div class="container">
        <div class="row text-center text-xs-center text-sm-left text-md-left">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <h5>About RECIPE </h5>
                <ul class="list-unstyled">
                    <li style="margin-bottom: 1em;">RECIPE allows you to create custom and private recipes that you can time share and collaborate with your family, friends and colleagues. </li>
                    <li>RECIPE makes use of session variables to keep track of users signed in.</li>


                </ul>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <h5>CONTACT US</h5>
                <ul class="list-unstyled">
                    <li style="margin-bottom: 1em;">Dalhousie University, Faculty of Computer Science, 6050 University Avenue, Halifax, NS B3H 1W5</li>
                    <li style="margin-bottom: 1em;">Email: navjotsappal@dal.ca</li>
                    <li>Phone: (782) 234-5427</li>
                </ul>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4">
                <h5>NAVIGATE</h5>
                <ul class="list-unstyled quick-links">
                    <li><a href="faq.php"><i class="fa fa-angle-double-right"></i>Frequently Asked Questions</a></li>
                    <li><a href="privacyPolicy.php"><i class="fa fa-angle-double-right"></i>Privacy Policy</a></li>
                    <li><a href="terms.php"><i class="fa fa-angle-double-right"></i>Terms of Use</a></li>
                    <li><a href="privacyPolicy.php"><i class="fa fa-angle-double-right"></i>Cookie Policy</a></li>
                    <li><a href="faq.php"><i class="fa fa-angle-double-right"></i>Need more Help </a></li>


                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
                <ul class="list-unstyled list-inline social text-center">
                    <li class="list-inline-item"><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="https://plus.google.com/discover"><i class="fa fa-google-plus"></i></a></li>
                    <li class="list-inline-item"><a href="https://www.pinterest.ca/"><i class="fa fa-pinterest"></i></a></li>


                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                <p ><u>
                       <?php
                          if(isset($_SESSION['email']))
                          {
                              ?>
                                      <a href="myRecipes.php">
                               <?php

                          }
                          else{
                              ?>
                                      <a href="index.php">
                              <?php
                          }
                       ?>

                            <b>RECIPE</b> </a></u>  is a research project undertaken by Navjot Singh Sappal as a prerequisite for the fulfilment of MACS program at Dalhousie University. </p>
                <p class="h6">&copy; Navjot Singh Sappal. All rights reserved. </p>
            </div>

        </div>
    </div>
</section>
<!-- ./Footer -->