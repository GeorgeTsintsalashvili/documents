@extends('layouts.site')

@section('content')

<!--- Main content start ------>

<!-- Breadcrumb -->
			<div class="breadcrumb">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<a class="breadcrumb-part breadcrumb-link-1" href="/">
									<i class="fa fa-home"></i>
								</a>
								<span class="last-breadcrumb-part font-3">კონტაქტი</span>
							</div>
						</div>
					</div>
			</div>
	 <!-- /Breadcrumb -->

        <div class="columns-container">
            <div id="columns" class="container dorContactStyle1">

							<div class="row">
                <div class="center_column  dor-normal-cols col-xs-12 col-sm-12">
                  <div id="contact-notification">
                   <span class="font-4 notification-text">
                     <a id="notification" href="#notification" class="main-phrase"></a>
                   </span>
                   <span id="close">
                     <i class="fa fa-times"></i>
                   </span>
                  </div>
                 </div>
                </div>

                <div class="row">
                    <div id="center_column" class="center_column dor-two-cols col-xs-12 col-sm-12">
                        <div id="contact-form-style1">
                          <div class="clearfix">
                            <div class="group-contact-form">
                              <div class="form-info-contact col-xs-12 col-sm-5 col-md-5">
                                <h2 class="font-2">მოგვწერეთ</h2>
																	<form action="/contact/sendMessage" method="POST" class="contact-form-box">
                                       <div class="form-group-input row">
                                         <div class="form-group col-lg-12 col-sm-12 col-xs-12">
                                          <input class="form-control grey font-4" type="text" name="name" placeholder="სახელი და გვარი"/>
                                         </div>
                                        </div>
																				<div class="form-group-input row">
																				 <div class="form-group col-lg-12 col-sm-12 col-xs-12">
																					<input class="form-control grey font-4" type="text" name="email" value="" placeholder="ელ. ფოსტის მისამართი"/>
																				 </div>
																				</div>

																				<div class="form-group-input row">
																				 <div class="form-group col-lg-12 col-sm-12 col-xs-12">
																					<input class="form-control grey font-4" type="text" name="phone" placeholder="მობილური ტელეფონის ნომერი"/>
																				 </div>
																				</div>

                                         <div class="form-group-area">
                                          <div class="form-group">
                                            <textarea class="form-control font-4" rows="8" name="message" placeholder="აკრიფეთ ტექსტი"></textarea>
                                          </div>
                                         </div>

                                         <div class="submit">
																					 {{ csrf_field() }}
                                           <button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium">
																						<b class="font-2">შეტყობინების გაგზავნა</b>
																					 </button>
                                          </div>
																				 </form>
                                        </div>
																				<div class="text-info-contact col-xs-12 col-sm-7 col-md-7">
														              <iframe width="100%" height="400px" src="{!! $generalData['contact'] -> googleMapLink !!}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
																				  <div class="row">
																					 <input readonly id="address-link" style="z-index: -1; position: absolute" value="{!! $generalData['contact'] -> googleMapLink !!}">
																					  <a id="address-copy-button">
                                             <span class="font-4"> მისამართის ბმულის დაკოპირება </span>
																					  </a>
																					</div>
	                                      </div>
                                      </div>
                                    </div>
                                 </div>
                             </div>
                       <!-- #center_column -->
                    </div>
                <!-- .row -->
            </div>
            <!-- #columns -->
        </div>
      <!-- .columns-container -->

<link rel="stylesheet" href="/css/feedback.css" type="text/css" media="all" />

<script type="text/javascript" src="/js/feedback.js"></script>

@endsection
