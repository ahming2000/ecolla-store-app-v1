<?php
//Set default value // '@' is to ignore the error message on null variable
if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;

//Initial
$SYMBOL = "../";
$upperDirectory = "";
for($i = 0; $i < $upperDirectoryCount; $i++){
    $upperDirectory = $upperDirectory.$SYMBOL;
}
?>
<footer class="mt-5">
    <div class="p-4" style="background-color:#3c3e44;">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-mb-6 col-sm-6">
                    <div class="container-fluid m-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.610069720882!2d101.14378741460057!3d4.328107998352038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cae2bc71984c77%3A0x85e97a678280a2b!2s2365%2C%20Jalan%20Hala%20Timah%203%2C%20Taman%20Kolej%20Perdana%2C%2031900%20Kampar%2C%20Negeri%20Perak!5e0!3m2!1sen!2smy!4v1603436959003!5m2!1sen!2smy"
                        width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>

                <div class="col-lg-3 col-mb-3 col-sm-3">
                    <h4 class="font-color font-weight-bold">我们的位置</h4>
                    <hr class="footer-hr">
                    <p class="text-uppercase font-color">2365, Jalan Hala Timah 3 <br>Taman Kolej Perdana
                        <br>31900 Kampar Negeri Perak</p>
                    </div>

                    <div class="col-lg-3 col-mb-3 col-sm-3">
                        <h4 class='font-color font-weight-bold'>联系我们</h4>
                        <hr class="footer-hr">
                        <p class="font-color"><i class="fas fa-phone pr-2"></i>012-3456789</p>
                        <p class="font-color"><i class="fab fa-facebook-square pr-2"></i><a href="https://www.facebook.com/Ecolla-e%E5%8F%A3%E4%B9%90-2347940035424278">Ecolla e口乐</a></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="row m-0 pt-3 pb-3 logo-bt">
            <div class="col">
                <div class="text-center">
                    <img src="<?php echo $upperDirectory; ?>assets/images/icon/ecolla_icon.png" width="20" height="20" alt="logo" loading="lazy">
                    <span class="font-color">ε口乐</span>
                </div>
            </div>
        </footer>
