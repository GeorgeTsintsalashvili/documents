@extends('layouts.site')

@section('content')

<!--- main content start ------->

<!-- Breadcrumb -->
			<div class="breadcrumb">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<a class="breadcrumb-part breadcrumb-link-1" href="/">
									<i class="fa fa-home"></i>
								</a>
								<span class="last-breadcrumb-part font-3">სისტემური ბლოკის კონფიგურატორი</span>
							</div>
						</div>
					</div>
			</div>
	 <!-- /Breadcrumb -->

			<div class="columns-container">
					<div id="columns" class="container">

						<div class="row">
						  <div class="col-sm-8">
						    <div id="general-notification" style="display: none">
						      <span class="font-4 notification-text">
										<i class="fa fa-exclamation" aria-hidden="true"></i>
						        <a href="#general-notification" id="main-notification"> &nbsp; </a>
						      </span>
						       <span id="general-notification-close">
						         <i class="fa fa-times"></i>
						       </span>
						      </div>
						    </div>
						  </div>

							<div class="row">
              <div class="col-sm-8" id="system-block-parts-left-column">

              <!--- Processor --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
                <div class="computer-part-container processor" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/019-processor.svg">
												<img src="/images/computerParts/019-processor.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">პროცესორი</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
                        პროცესორი – მიკროსქემა, რომელიც წარმოადგენს კომპიუტერის მთავარ კომპონენტს, მართავს მის მუშაობას და აწარმოებს ყველა სახის გამოთვლებს,
												ანუ ამუშავებს ინფორმაციას. კომპიუტერის სწრაფქმედება და წარმადობა დიდადაა დამოკიდებული პროცესორის ტაქტურ სიხშირესა და ბირთვების რაოდენობაზე.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="processors" data-part-default-title="პროცესორი" data-window-title="პროცესორები">
												<button class="part-select-button" >
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
												<span class="key-part font-3">
												 <i class="fas fa-exclamation"></i>
												 <b>საკვანძო კომპონენტი</b>
												</span>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

						 <!--- Motherboard --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
								<div class="computer-part-container motherboard" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/014-motherboard.svg">
												<img src="/images/computerParts/014-motherboard.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">დედაპლატა</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												დედაპლატა წარმოადგენს სისტემური ბლოკის ძირითად ნაწილს, რომელიც განსაზღვრავს კომპიუტერის
												არქიტექტურასა და მწარმოებლურობას. მას ასევე უწოდებენ სისტემურ პლატას, ძირითად ან მთავარ პლატას.
												იგი აკავშირებს სხვადასხვა მოწყობილობებს პროცესორთან და არეგულირებს ამ მოწყობილობებიდან წამოსულ იმპულსებს.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="motherboards" data-part-default-title="დედაპლატა" data-window-title="დედაპლატები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
												<span class="key-part font-3">
                         <i class="fas fa-exclamation"></i>
												 <b>საკვანძო კომპონენტი</b>
												</span>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							<!--- Memory --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
								<div class="computer-part-container memory" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/021-ram.svg">
												<img src="/images/computerParts/021-ram.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">ოპერატიული მეხსიერება</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												ოპერატიული მეხსიერება ინფორმაციის დროებითი საცავია, რომელშიც პროცესორის მიერ დასამუშავებელი მონაცემები და პროგრამები იწერება.
												რაც უფრო მეტია ოპერატიული მეხსიერების მოცულობა და ტაქტური სიხშირე, მით უფრო მაღალია კომპიუტერის წარმადობა.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="memories" data-part-default-title="ოპერატიული მეხსიერება" data-window-title="ოპერატიულები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							<!--- Video card --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
								<div class="computer-part-container videoCard" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/006-graphics card.svg">
												<img src="/images/computerParts/006-graphics card.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">ვიდეობარათი</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												ვიდეობარათი - კომპიუტერის შემადგენელი ნაწილი, რომლის დანიშნულებაა გრაფიკული ინფორმაციის დამუშავება და მონიტორზე მოწოდება.
												ინფორმაციის დამუშავება ხდება გრაფიკული პროცესორის (GPU) საშუალებით. გრაფიკული პროცესორის ბირთვების რაოდენობა და ვიდეო
												მეხსიერების მოცულობა დიდ გავლენას ახდენს ამ მოწყობილობის წარმადობაზე.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="videoCards" data-part-default-title="ვიდეობარათი" data-window-title="ვიდეობარათები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							<!--- Power supply --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
								<div class="computer-part-container powerSupply" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/005-power supply.svg">
												<img src="/images/computerParts/005-power supply.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">კვების ბლოკი</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												კვების ბლოკის დანიშნულება არის სისტემური ბლოკის ყველა კვანძისთვის ელექტროენერგიის მიწოდება.
												კომპიუტერის ამ კომპონენტის ძირითად მახასიათებელს წარმოადგენს სიმძლავრე.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="powerSupplies" data-part-default-title="კვების ბლოკი" data-window-title="კვების ბლოკები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							<!--- Processor cooler --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
								<div class="computer-part-container processorCooler" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/008-fan.svg">
												<img src="/images/computerParts/008-fan.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">პროცესორის გამაგრილებელი</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												მოწყობილობა, რომლის დანიშნულებაა პროცესორის გაგრილება.
												ამ ნაწილის შერჩევისას აუცილებელია გავითვალისწინოთ პროცესორის
												სიმძლავრე და სამუშაო დატვირთვა.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="processorCoolers" data-part-default-title="პროცესორის გამაგრილებელი" data-window-title="პროცესორის გამაგრილებლები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							<!--- Case --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
								<div class="computer-part-container case" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/002-case.svg">
												<img src="/images/computerParts/002-case.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">კეისი</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												კეისი წარმოადგენს კარკასს, რომელშიც ხდება კომპიუტერის მაკომპლექტებლების მოთავსება.
												ამ კომპონენტის შერჩევისას აუცილებელია გავითვალისწინოთ ისეთი მახასიათებელი, როგორიცა ფორმფაქტორი.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="cases" data-part-default-title="კეისი" data-window-title="კეისები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

              <!--- Hard disk drive --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
                <div class="computer-part-container hardDiskDrive" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/007-hard disk.svg">
												<img src="/images/computerParts/007-hard disk.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">მყარი დისკი</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												მყარი დისკი წარმოადგენს ინფორმაციის მუდმივ საცავს. ამ მოწყობილობის ძირითადი
												მახასიათებლებია მაგნიტური დისკის ბრუნვის სიხშირე და მეხსიერების მოცულობა.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="hardDiskDrives" data-part-default-title="მყარი დისკი" data-window-title="მყარი დისკები">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							<!--- Solid state drive --->

							<div class="row computer-part-section">
							 <div class="col-sm-12">
                <div class="computer-part-container solidStateDrive" data-part-selected="0">
									<div class="row">
										<div class="col-sm-4 computer-part-left-column">
											<div class="computer-part-image-container" data-default-image="/images/computerParts/027-ssd drive.svg">
												<img src="/images/computerParts/027-ssd drive.svg" width="70%">
											</div>
										</div>
										<div class="col-sm-8 computer-part-right-column">
											<div class="computer-part-title-container">
												<h1 class="font-4">SSD მეხსიერება</h1>
											</div>
											<div class="computer-part-description-container visible font-4">
												მყარი დისკის მსგავსად გამოიყენება ინფორმაციის ხანგრძლივად შენახვისთვის,
												მაგრამ წაკითხვისა და ჩაწერის ოპერაციებს ასრულებს გაცილებით სწრაფად.
											</div>

											<div class="computer-part-specifications-container invisible">
												<div class="row">
													<div class="col-sm-9 part-specifications"></div>
													<div class="col-sm-3 part-additional-data">
														<div class="part-current-price-container">
														 <span class="part-current-price"></span>
													 </div>
													 <div class="part-old-price-container">
														 <span class="part-old-price"></span>
													 </div>
													</div>
												</div>
											</div>

											<div class="computer-part-controls-container" data-parts-to-request="solidStateDrives" data-part-default-title="SSD მეხსიერება" data-window-title="SSD მეხსიერება">
												<button class="part-select-button">
													<i class="fa fa-plus"></i>
													<span class="font-3">არჩევა</span>
												</button>
												<button class="part-change-button" style="display: none">
													<i class="fas fa-retweet"></i>
													<span class="font-3">შეცვლა</span>
												</button>
												<button class="part-delete-button" style="display: none">
													<i class="fa fa-times"></i>
													<span class="font-3">მოშორება</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							 </div>
							</div>

							</div>

							<div class="col-sm-4" id="system-block-parts-right-column">
                <div class="row">
									<div class="col-sm-12">
										<div class="price-title-container">
											<h1 class="font-4">სისტემის ფასი</h1>
										</div>
										<div class="price-container">
											<h1>
												<span class="currency-sign"> ₾ </span>
												<span class="calculated-price">0</span>
											</h1>
										</div>
										<div class="reset-button-container">
											<button class="configuration-reset-button">
												<i class="fa fa-sync"></i>
												<span class="font-3">კონფიგურაციის გასუფთავება</span>
											</button>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="ready-configuration-container">
                   <div class="row">
										 <div class="col-sm-12">
                      <div class="ready-configuration-button-container">
												<a href="/computers" target="_blank" id="ready-configuration-button">
													<i class="fas fa-cog"></i>
													<span class="font-3">მზა კონფიგურაციები</span>
												</a>
											</div>
										 </div>
									 </div>

									<div class="row">
										 <div class="col-sm-12">
										 <button data-address="/configurator/document" id="download-configuration-button">
											 <i class="fas fa-file-pdf"></i>
											 <span class="font-3">კონფიგურაციის გადმოწერა</span>
										 </button>
										</div>
									 </div>

									 <div class="row" id="statement">
											<div class="col-sm-12">
											 <div class="configuration-statement-container">
                         <div class="statement-row">
													 <span>არჩეული კომპლექტაციის შესაკვეთად დაგვიკავშირიდთ ნომერზე ან მოგვწერეთ მესენჯერის საშუალებით.</span>
												 </div>
												<div class="statement-row">
													<span>სისტემის ყველა კომპონენტის არჩევის შემთხვევაში აწყობა და პროგრამული უზრუნველყოფა უფასოა.</span>
												</div>
												<div class="statement-row">
													<span>სისტემური ბლოკი იწყობა შეკვეთიდან 24 საათში.</span>
												</div>
												</div>
										 </div>
										</div>

									</div>
               </div>
             </div>
            </div>
           <!-- .row -->
         </div>
        <!-- #columns -->
      </div>

			<div class="blockDorado10 clearfix">
					<div class="container">
						<div class="row"></div>
					</div>
			</div>

     <!--- computer part select window --->

     <div id="part-select-overlay" style="display: none">
		  <div id="part-select-window">
			  <div class="part-select-container"></div>
			 </div>
			</div>

      <!--- Parts parameters --->

			<input type="hidden" class="chipset" value="0">
			<input type="hidden" class="cpu-socket" value="0">
			<input type="hidden" class="memory-type" value="0">
			<input type="hidden" class="form-factor" value="0">
			<input type="hidden" class="ssd-type" value="0">
			<input type="hidden" class="required-power" value="0">
			<input type="hidden" class="max-memory" value="0">
			<input type="hidden" class="memory-slots" value="0">

			<!--- Parts parameters prices --->

			<input type="hidden" class="processor-price" value="0">
			<input type="hidden" class="motherboard-price" value="0">
			<input type="hidden" class="memory-price" value="0">
			<input type="hidden" class="processor-cooler-price" value="0">
			<input type="hidden" class="case-price" value="0">
			<input type="hidden" class="power-supply-price" value="0">
			<input type="hidden" class="video-card-price" value="0">
			<input type="hidden" class="hard-disk-drive-price" value="0">
			<input type="hidden" class="solid-state-drive-price" value="0">

      <!-- Parts identifiers (update) --->

			<input type="hidden" class="processorId" value="0">
			<input type="hidden" class="motherboardId" value="0">
			<input type="hidden" class="memoryId" value="0">
			<input type="hidden" class="processorCoolerId" value="0">
			<input type="hidden" class="caseId" value="0">
			<input type="hidden" class="powerSupplyId" value="0">
			<input type="hidden" class="videoCardId" value="0">
			<input type="hidden" class="hardDiskDriveId" value="0">
			<input type="hidden" class="solidStateDriveId" value="0">

      <!--- Configurator JS --->

			<script type="text/javascript" src="/js/configurator.js"> </script>

      <!--- Configurator CSS -->

			<link rel="stylesheet" href="/css/configurator.css" type="text/css" />

			<!--- View page CSS --->

			<link rel="stylesheet" href="/css/view-page.css" type="text/css" />

@endsection
