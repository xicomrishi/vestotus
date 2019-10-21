			<div class="top-banner" style="text-align:center">
				<?php
				$banner = BASEURL.'images/main-banner.jpg';
				
				?>
				<img src="<?= $banner ?>" width="100%" height="200px"/>
				<span class="green-strip"></span>
				<h2><?= $page['title'] ?></h2>
			</div>
			<div class="content-section">
				<div class="container">
				 <section class="section bgw">
            <div class="container">

                <div class="section-title-2 text-center">
                    <h2>CONTACT DETAILS</h2>
                    <p class="lead">For your pre-sale questions, please use form below</p>
                    <hr>
                </div><!-- end section-title -->

                <div class="row">
                    <div class="col-md-5">
                        <div class="widget">
                            <p>If you need help before, during or after your purchase, this is the place to be. Please use below contact details for all your pre-sale questions, contact questions.</p>
                            <hr>
                            <ul class="contact-details">
                               <!--  <li><i class="fa fa-link"></i> <a href="#">www.yoursite.com</a></li> -->
                                <li><i class="fa fa-envelope-o"></i> <a href="mailto:<?= $setting['contact_email'] ?>"><?= $setting['contact_email'] ?></a></li>
                                <li><i class="fa fa-phone"></i> +<?= $setting['contact_phone'] ?></li>
                                <!-- <li><i class="fa fa-fax"></i> +90 123 45 68</li> -->
                                <li><i class="fa fa-home"></i> <?= $setting['contact_address'] ?></li>
                            </ul>
                            <hr>
                            <div class="social-icons">
                                <ul class="list-inline">
                                <li class="facebook"><a data-toggle="tooltip" data-placement="top" title="Facebook" href="<?= $setting['fb_link'] ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li class="google"><a data-toggle="tooltip" data-placement="top" title="Google Plus" href="<?= $setting['gplus_link'] ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                <li class="twitter"><a data-toggle="tooltip" data-placement="top" title="Twitter" href="<?= $setting['twitter_link'] ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <li class="linkedin"><a data-toggle="tooltip" data-placement="top" title="Linkedin" href="<?= $setting['li_link'] ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                <li class="pinterest"><a data-toggle="tooltip" data-placement="top" title="Pinterest" href="<?= $setting['pinterest'] ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                                <li class="skype"><a data-toggle="tooltip" data-placement="top" title="Skype" href="<?= $setting['skype'] ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
                                <li class="vimeo"><a data-toggle="tooltip" data-placement="top" title="Vimeo" href="<?= $setting['vimeo'] ?>" target="_blank"><i class="fa fa-vimeo"></i></a></li>
                                <li class="youtube"><a data-toggle="tooltip" data-placement="top" title="Youtube" href="<?= $setting['youtube_link'] ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
                                </ul>
                            </div><!-- end social icons -->
                        </div><!-- end widget -->
                    </div>   
                    <div class="col-md-7">
                        <div class="contact_form">
                            <div id="message"></div>
                            <?= $this->Form->create($contact,['id'=>'contactform','class'=>'row']) ?>
                                <div class="col-md-12">
                                <?= $this->Form->input('name',['label'=>false,'class'=>'form-control','placeholder'=>'Name'])?>
                                <?= $this->Form->input('email',['label'=>false,'class'=>'form-control','placeholder'=>'Email'])?>
                                <?= $this->Form->input('phone',['label'=>false,'class'=>'form-control','placeholder'=>'Phone'])?>
                                <?= $this->Form->input('subject',['label'=>false,'class'=>'form-control','placeholder'=>'Subject'])?>
                                <?= $this->Form->textarea('comment',['class'=>'form-control','placeholder'=>'Message Below'])?>
                               <?= $this->Form->submit('SEND',['id'=>'submit','class'=>'btn btn-primary']) ?>
                                
                                </div>
                            </form> 
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end section -->

        <div class="googlemap">
            <div id="map"></div>
        </div><!-- end googlemap -->

				</div>
			</div>
			<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
			<script type="text/javascript">
				    /* ==============================================
    MAP -->
    =============================================== */
        var locations = [
            ['<div class="infobox"><h3 class="title"><a href="#">OUR OFFICE</a></h3><span><?= $setting['contact_address'] ?></span><span>+90 555 666 77 88</span></div>', <?= $setting['lat'] ?>, <?= $setting['lng'] ?>, 2]
            ];     
            var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            scrollwheel: false,
            navigationControl: true,
            mapTypeControl: false,
            scaleControl: false,
            draggable: true,
            styles: [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#3ca1db"
            },
            {
                "visibility": "on"
            }
        ]
    }
],
            center: new google.maps.LatLng(<?= $setting['lat'] ?>, <?= $setting['lng'] ?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            for (i = 0; i < locations.length; i++) {  
            marker = new google.maps.Marker({ 
            position: new google.maps.LatLng(locations[i][1], locations[i][2]), 
            map: map ,
            icon: 'images/marker.png'
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
            }
            })(marker, i));
        }
			</script>