 <nav class="merchant-navbar navbar navbar-expand-lg center-nav transparent navbar-light p-3 fixed-top">
     <div class="container flex-lg-row flex-nowrap align-items-center">
         <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start text-bg-dark ">
             <div class="offcanvas-header w-90 ">
                 <h3 class="text-white fs-30 mb-0">{{ settings()->name }}</h3>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                     aria-label="Close"></button>
             </div>
             <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100 w-90">
                 <div class="dashboard-header">
                     <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                         <a class="navbar-brand" href="{{ url('/dashboard') }}">
                             <img src="{{ settings()->logo_image }}" class="logo" />
                         </a>

                         <div class=" navbar-collapse  " id="navbarSupportedContent">
                             <ul class="navbar-nav ml-auto navbar-right-top merchant-mobile-navbar-nav">
                                 <li class="nav-item lang">
                                     <div class="form-group col-12 pt-1">
                                         <div class="dropdown lang-dropdown  changeLocale ">
                                             @include('backend.partials.language')
                                         </div>
                                     </div>
                                 </li>
                                 <li class="nav-item lang">
                                     <div class="form-group col-12 pt-1">
                                         <div class="dropdown lang-dropdown  changeLocale ">
                                             <button class="btn  dropdown-toggle merchantpanelAddbutton" type="button"
                                                 id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                 aria-expanded="false" style=" color:#455560!important;">
                                                 <i class="fa fa-plus"></i>
                                             </button>
                                             <div class="dropdown-menu merchantpanelAddDropdown"
                                                 aria-labelledby="dropdownMenuButton">
                                                 <button type="button" class="dropdown-item" data-toggle="modal"
                                                     data-target="#pickup-request">{{ __('pickupRequest.pickup_request') }}</button>
                                                 <a class="dropdown-item "
                                                     href="{{ route('merchant-panel.parcel.index') }}">{{ __('menus.parcel') }}</a>
                                                 <a class="dropdown-item "
                                                     href="{{ route('merchant-panel.support.index') }}">{{ __('menus.support') }}</a>
                                                 <a class="dropdown-item "
                                                     href="{{ route('merchant-panel.shops.index') }}">
                                                     {{ __('parcel.shop') }}</a>
                                             </div>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item {{ request()->is('/*') ? 'active' : '' }}"
                                         href="{{ url('/') }}"><i class="fa fa-home"></i>
                                         {{ __('dashboard.title') }}</a>
                                 </li>

                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item {{ request()->is('merchant/support*') ? 'active' : '' }}"
                                         href="{{ route('merchant-panel.support.index') }}"><i
                                             class="fa fa-comments"></i> {{ __('menus.support') }}</a>
                                 </li>

                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item" href="#" id="navbarDropdownMenuLinkAccounts"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <div class="d-flex justify-content-between">
                                             <span><i class="fa fa-users"></i> {{ __('account.title') }}</span>
                                             <span><i class="fa fa-angle-down"></i></span>
                                         </div>
                                     </a>
                                     <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                         aria-labelledby="navbarDropdownMenuLinkAccounts">
                                         <div class="nav-user-info">
                                             <h5 class="mb-0 text-white nav-user-name">{{ __('account.title') }}</h5>
                                         </div>

                                         <a class="dropdown-item {{ request()->is('merchant/payment/received*') ? 'active' : '' }}"
                                             href="{{ route('online.payment.received') }}">
                                             {{ __('menus.payments_received') }}</a>
                                         {{-- payout --}}
                                         <a class="dropdown-item {{ request()->is('merchant/online-payment*') ? 'active' : '' }}"
                                             href="{{ route('online.payment.index') }}"> {{ __('menus.payout') }}</a>
                                         <a class="dropdown-item {{ request()->is('merchant/invoice*') ? 'active' : '' }}"
                                             href="{{ route('merchant.panel.invoice.index') }}">{{ __('menus.invoice') }}</a>

                                     </div>
                                 </li>


                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item {{ request()->is('merchant/parcel/*') ? 'active' : '' }}"
                                         href="{{ route('merchant-panel.parcel.index') }}"><i class="fa fa-dolly"></i>
                                         {{ __('menus.parcel') }}</a>
                                 </li>
                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item {{ request()->is('merchant/parcel-bank*') ? 'active' : '' }}"
                                         href="{{ route('merchant-panel.parcel-bank.index') }}"><i
                                             class="fa fa-map"></i> {{ __('menus.parcel_bank') }}</a>
                                 </li>


                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item" href="#" id="navbarDropdownMenuLinkReports"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <div class="d-flex justify-content-between">
                                             <span><i class="fas fa-print"></i> {{ __('reports.title') }}</span>
                                             <span><i class="fa fa-angle-down"></i></span>
                                         </div>
                                     </a>
                                     <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                         aria-labelledby="navbarDropdownMenuLinkReports">
                                         <div class="nav-user-info">
                                             <h5 class="mb-0 text-white nav-user-name">{{ __('reports.title') }}</h5>
                                         </div>
                                         <a class="dropdown-item {{ request()->is('merchant/reports/parcel-reports*', 'merchant/reports/parcel-filter-reports') ? 'active' : '' }}"
                                             href="{{ route('merchant-panel.parcel.reports') }}">{{ __('reports.parcel_reports') }}</a>

                                         <a class="dropdown-item {{ request()->is('merchant/reports/total-summery*', 'merchant/reports/total-summery-filter*') ? 'active' : '' }}"
                                             href="{{ route('merchant.total.summery') }}">{{ __('menus.parcel_total_summery') }}</a>
                                         <a class="dropdown-item {{ request()->is('merchant/accounts/account-transaction*') ? 'active' : '' }}"
                                             href="{{ route('merchant.accounts.account-transaction.index') }}">
                                             {{ __('menus.account_transaction') }}</a>
                                         <a class="dropdown-item {{ request()->is('merchant/accounts/statements*') ? 'active' : '' }}"
                                             href="{{ route('merchant.accounts.statements.index') }}">
                                             {{ __('menus.statements') }}</a>

                                     </div>
                                 </li>


                                 <li class="nav-item dropdown nav-user navbar_menus">
                                     <a class="dropdown-item" href="#" id="navbarDropdownMenuLinkSettings"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <div class="d-flex justify-content-between">
                                             <span><i class="fa fa-fw fa-cogs"></i> {{ __('menus.settings') }}</span>
                                             <span><i class="fa fa-angle-down"></i></span>
                                         </div>
                                     </a>
                                     <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                         aria-labelledby="navbarDropdownMenuLinkSettings">
                                         <div class="nav-user-info">
                                             <h5 class="mb-0 text-white nav-user-name">{{ __('menus.settings') }}</h5>
                                         </div>

                                         <a class="dropdown-item {{ request()->is('merchant/settings/cod-charges*') ? 'active' : '' }}"
                                             href="{{ route('merchant.cod-charges.index') }}">
                                             {{ __('menus.cod_charges') }}</a>
                                         <a class="dropdown-item {{ request()->is('merchant/settings/delivery-charges*') ? 'active' : ' ' }}"
                                             href="{{ route('merchant.delivery-charges.index') }}">
                                             {{ __('menus.delivery_charges') }}</a>
                                         <a class="dropdown-item {{ request()->is('merchant/shops*') ? 'active' : '' }}"
                                             href="{{ route('merchant-panel.shops.index') }}">
                                             {{ __('parcel.shop') }}</a>

                                     </div>
                                 </li>


                                 <li class="nav-item dropdown merchant-panel notification d-lg-block ">
                                     <a class="nav-link nav-icons mt-md-3" href="#"
                                         id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true"
                                         aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span
                                             class="indicator"></span></a>
                                     <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                         <li>
                                             <div class="notification-title"> Notification</div>
                                             <div class="notification-list">
                                                 <div class="list-group">
                                                     @include('backend.merchant_panel.partials.notification')
                                                 </div>
                                             </div>
                                         </li>
                                     </ul>
                                 </li>

                                 <li class="nav-item dropdown connection mt-lg-3 mt-md-0 d-lg-block">
                                     <a class="dropdown-item" href="{{ route('merchant-panel.news-offer.index') }}"
                                         data-toggle="tooltip" data-placement="top"
                                         title="{{ __('news_offer.title') }}"> <i
                                             class="fas fa-newspaper font-20"></i> </a>
                                 </li>
                                 <li class="nav-item dropdown connection mt-lg-3 mt-md-0 d-lg-block">
                                     <button class="btn btn-sm btn-primary"> {{ __('merchant.wallet') }} :
                                         {{ settings()->currency }} {{ Auth::user()->merchant->wallet_balance }}
                                     </button>
                                 </li>
                                 <li class="nav-item dropdown nav-user d-lg-block">
                                     @include('backend.merchant_panel.partials.profile_menu')
                                 </li>

                             </ul>
                         </div>
                     </nav>
                 </div>

             </div>
         </div>

         <div class="navbar-other w-100 d-flex  justify-content-between">
             <div>
                 <a href="{{ url('/') }}">
                     <img src="{{ settings()->logo_image }}" style="margin-top: 10px" width="150"
                         alt="Logo">
                 </a>
             </div>

             <ul class="navbar-nav flex-row align-items-center  ">

                 <li class="nav-item dropdown  merchant-panel notification  ">
                     <a class="nav-link nav-icons mt-md-3" href="#" id="navbarDropdownMenuLink1"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                             class="fas fa-fw fa-bell"></i> <span class="indicator merchant-indicator "></span></a>
                     <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                         <li>
                             <div class="notification-title"> Notification</div>
                             <div class="notification-list">
                                 <div class="list-group">
                                     @include('backend.merchant_panel.partials.notification')
                                 </div>
                             </div>
                         </li>

                     </ul>
                 </li>

                 <li class="nav-item dropdown connection mt-md-3">
                     <a class="dropdown-item m-newsoffers" href="{{ route('merchant-panel.news-offer.index') }}"
                         data-toggle="tooltip" data-placement="top" title="{{ __('news_offer.title') }}"> <i
                             class="fas fa-newspaper font-20"></i> </a>
                 </li>

                 <li class="nav-item dropdown nav-user mobile mobilePlusBtn">
                     <button class="mtext-color btn nav-link dropdown-toggle merchantpanelAddbutton "
                         style="color:#455560!important;padding: 5px 10px!important;" type="button"
                         id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-plus"></i>
                     </button>
                     <div class="dropdown-menu  dropdown-menu-right nav-user-dropdown"
                         aria-labelledby="dropdownMenuButton">
                         <button type="button" class="dropdown-item" data-toggle="modal"
                             data-target="#pickup-request">{{ __('pickupRequest.pickup_request') }}</button>
                         <a class="dropdown-item "
                             href="{{ route('merchant-panel.parcel.index') }}">{{ __('menus.parcel') }}</a>
                         <a class="dropdown-item "
                             href="{{ route('merchant-panel.support.index') }}">{{ __('menus.support') }}</a>
                         <a class="dropdown-item " href="{{ route('merchant-panel.shops.index') }}">
                             {{ __('parcel.shop') }}</a>
                     </div>
                 </li>

                 <li class="nav-item dropdown connection mt-md-3">
                     <button class="btn btn-sm btn-primary me-2"> {{ __('merchant.wallet') }} :
                         {{ settings()->currency }} {{ Auth::user()->merchant->wallet_balance }} </button>
                 </li>

                 <li class="nav-item dropdown nav-user mobile">
                     @include('backend.merchant_panel.partials.profile_menu')
                 </li>

                 <li class="nav-item d-lg-none">
                     <button class="offcanvas-nav-btn" type="button" data-bs-toggle="offcanvas"
                         data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"><span
                             class="navbar-toggler-icon"></span></button>
                 </li>
             </ul>
         </div>


     </div>
 </nav>


 @include('backend.merchant_panel.pickup_request.pickup_request_modal')
 @include('backend.merchant_panel.pickup_request.regular_modal')
 @include('backend.merchant_panel.pickup_request.express_modal')
