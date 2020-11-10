<div class="container-fluid">

  <!-- Grid row -->
  <div class="row">

    <!-- Grid column -->
    <div class="col-md-12 mb-4">

      <div class="container text-center my-3">
        <div class="row mx-auto my-auto">
          <div id="itemcarousel" class="carousel slide w-100 " data-ride="carousel" data-interval="2000">
            <div class="carousel-inner w-100 vv-3" role="listbox">
              <div class="carousel-item active">
                <div class="col-2">
                  <img class="d-block img-fluid"
                    src="assets/images/items/1/1.png">
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-2">
                  <img class="d-block img-fluid"
                    src="assets/images/items/1/2.png">
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-2">
                  <img class="d-block img-fluid"
                    src="assets/images/items/1/3.png">
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-2">
                  <img class="d-block img-fluid"
                    src="assets/images/items/1/4.png">
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-2">
                  <img class="d-block img-fluid"
                    src="assets/images/items/1/5.png">
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-2">
                  <img class="d-block img-fluid"
                    src="assets/images/items/1/6.png">
                </div>
              </div>
            </div>
            <!--ctrl
            <a class="carousel-control-prev" href="#itemcarousel" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#itemcarousel" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
           ctrl-->
          </div>
        </div>
      </div>
 
    </div>
    <!-- Grid column -->

  </div>
  <!-- Grid row -->
  
</div>

<script>
$('#itemcarousel.carousel .carousel-item').each(function () {
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i = 0; i < 4; i++) {
    next = next.next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }

    next.children(':first-child').clone().appendTo($(this));
  }
});
</script>