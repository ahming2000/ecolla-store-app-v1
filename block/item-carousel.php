<div id="itemslide" class="carousel slide carousel-multi-item" data-interval="false">
  <div class= "carousel-inner item-slide row w-100 mx-auto" role="listbox">
  <!--first page-->
        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item active">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 1</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 2</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 3</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 4</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 5</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 6</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 7</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>
         
        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 8</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>

        <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 display-item">
            <div class="card mb-2 shadow">
                  <img class="card-img-top img-fluid" src="assets/images/ads/displayitem.jpg" alt="Card image">
                      <div class="card-body">
                          <h4 class="card-title">Item 9</h4>
                          <p class="card-text"><small class="text-muted">RM 0.00</small></p>
                      </div>
            </div>
        </div>


  </div> <!--carousel-inner-->

  <a class="carousel-control-prev" href="#itemslide" data-slide="prev">
  <i style="font-size: 30px" class="fas fa-chevron-circle-left"></i>
  </a>
  <a class="carousel-control-next" href="#itemslide" data-slide="next">
  <i style="font-size: 30px" class="fas fa-chevron-circle-right"></i>
  </a>

</div>

<script>
    $('#itemslide').on('slide.bs.carousel', function (e) {

/*

CC 2.0 License Iatek LLC 2018
Attribution required

*/

var $e = $(e.relatedTarget);

var idx = $e.index();
console.log("IDX :  " + idx);

var itemsPerSlide = $('#itemslide .carousel-item').length;
var totalItems = $('#itemslide .carousel-item').length;

if (idx >= totalItems-(itemsPerSlide-1)) {
    var it = itemsPerSlide - (totalItems - idx);
    for (var i=0; i<it; i++) {
        // append slides to end
        if (e.direction=="left") {
            $('#itemslide .carousel-item').eq(i).appendTo('#itemslide .carousel-inner');
        }
        else {
            $('#itemslide .carousel-item').eq(0).appendTo('#itemslide .carousel-inner');
        }
    }
}
});
</script>