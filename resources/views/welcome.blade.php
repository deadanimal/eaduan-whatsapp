@extends('layouts.main_portal')
<?php
?>
@section('content')
    <link rel="stylesheet" href="{{ url('assets/material-design-iconic-font/css/docs.md-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/chatbot/css/chatbot.css') }}">
    <div class="site-wrap" id="home-section">
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>
        <header>
            <div class="container">
                <div class="row align-items-center position-relative">
                    <div class="toggle-button d-inline-block d-lg-none">
                        <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black">
                            <span class="icon-menu h3"></span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="ftco-blocks-cover-1">
            <div class="ftco-cover-1 overlay"
                 style="background-image: url({{asset('assets/portal/images/kpdnhep.jpg')}})">
                <div class="container">
                    <div class="row align-items-center text-center">
                        <div class="col-lg-12 font-white">
                            <img src="{{asset('assets/portal/images/logo1white.png')}}"
                                 style="width: 30%;margin-bottom: 15px;">
                            <h2 class="text-white">{{__('portal.main_portal.title')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END .ftco-cover-1 -->
            <div class=" ftco-service-image-1 pb-5">
                <div class="container" style="max-width:900px">
                    <div class="owl-carousel owl-all">
                        <div class="service text-center">
                            <a href="{{ url('kepenggunaan') }}">
                                <img src="{{asset('assets/portal/images/aduanpengguna_'.session()->get('locale').'.jpg')}}" alt="aduan pengguna"
                                     class="img-fluid">
                            </a>
                        </div>
                        <div class="service text-center">
                            <a href="{{ url('integriti') }}">
                                <img src="{{asset('assets/portal/images/aduanintergriti_'.session()->get('locale').'.jpg')}}" alt="aduan integriti"
                                     class="img-fluid">
                            </a>
                        </div>
                        {{--          <div class="service text-center">--}}
                        {{--            <a href="https://helpdeskpsp.kpdnhep.gov.my/" target="_blank"><img src="assets/portal/images/aduanpsp.jpg" alt="Image" class="img-fluid"></a>--}}
                        {{--          </div>--}}
                    </div>

                    {{-- <div class="container-fluid">
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-lg-4 m-b-sm">
                                <a href="https://api.whatsapp.com/send?phone=60192794317" target="_blank">
                                    <img src="{{asset('assets/portal/images/whatsapp.jpg')}}" style="width: 100%; border-radius: 0.85rem;">
                                </a>
                            </div>
                            <div class="col-lg-4 m-b-sm">
                                <a href="http://flashchat.infopengguna.com/" target="_blank">
                                    <img src="{{asset('assets/portal/images/livechat.jpg')}}" style="width: 100%; border-radius: 0.85rem;">
                                </a>
                            </div>
                            <div class="col-lg-4 m-b-sm">
                                <a href="mailto:e-aduan@kpdnhep.gov.my">
                                    <img src="{{asset('assets/portal/images/emel.jpg')}}" style="width: 100%; border-radius: 0.85rem;">
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="text-center">
                        <h3 style="font-family:'Raleway'">{!! __('portal.main_portal.download_ez_adu_title') !!}</h3>
                        <a href="https://play.google.com/store/apps/details?id=com.kpdnkk.ezaduforandroid&hl=en_ZA"
                           target="_blank">
                            <img src="assets/portal/images/gplay.svg" style="width:144px">
                        </a>
                        <a href="https://apps.apple.com/my/app/ez-adu-kpdnkk/id1012529241"
                           target="_blank">
                            <img src="assets/portal/images/ios.svg" style="width:133px">
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- chatbot -->
    <div class="fabs">
        <div class="chat">
            <div class="chat_header">
                <div class="chat_option">
                    <div class="header_img">
                        <img src="https://chatbot.kpdnhep.gov.my/www/admin/files/kpdnhep/images/chatbotlogokpdn.jpg"/>
                    </div>
                    <span id="chat_head">Chat Bersama Cik Kiah</span> <br> <span class="agent">Chatbot KPDNHEP</span>
                    <!--span id="chat_fullscreen_loader" class="chat_fullscreen_loader" data-toggle="tooltip" data-placement="top" title="Besarkan Teringkap!"><i class="fullscreen zmdi zmdi-window-maximize"></i></span-->
                </div>

            </div>



            <div class="chat_body chat_login">
                <a id="chat_first_screen" class="fab" style="background-color:transparent;border-radius:0;box-shadow:none;background:url(https://chatbot.kpdnhep.gov.my/www/admin/files/kpdnhep/images/mainicon.png) no-repeat;background-size: 100% 100%;width:100px;height:100px;"><!--i class="zmdi zmdi-arrow-right"></i--></a>
                <p id="welcomemessage" style="padding-top:0px;">Hi, Saya Cik Kiah, chatbot KPDNHEP. Sila kemukakan pertanyaan anda mengenai aduan kepenggunaan dan saya akan cuba mendapatkan jawapan dari gedung ilmu atas talian.</p>
            </div>

            <div id="chat_converse" class="chat_conversion chat_converse">
                <a id="chat_first_screen" class="fab" style="background-color:transparent;border-radius:0;box-shadow:none;background:url(https://chatbot.kpdnhep.gov.my/www/admin/files/kpdnhep/images/mainicon.png) no-repeat;background-size: 100% 100%;width:100px;height:100px;"><!--i class="zmdi zmdi-arrow-right"></i--></a>
                <p style="padding-top:0px;padding: 20px;color: #888;text-align: center;">Hi, Saya Chatbot KPDNHEP.  Anda boleh bertanya apa-apa perkara mengenai KPDNHEP dan saya akan cuba mendapatkan jawapan dari gedung ilmu atas talian.</p>

            </div>
            <div id="chat_body" class="chat_body">
                <!--div class="chat_category">
                    <a id="chat_third_screen" class="fab"><i class="zmdi zmdi-arrow-right"></i></a>
                <p>What would you like to talk about?</p>
                <ul>
                    <li>Tech</li>
                    <li class="active">Sales</li>
                    <li >Pricing</li>
                    <li>other</li>
                </ul>
                </div-->

            </div>

            <div id="chat_form" class="chat_converse chat_form">
                <a id="chat_first_screen" class="fab" style="background-color:transparent;border-radius: 50%;border: 1px solid #2d2c97;box-shadow: 0px 1px 13px 0px rgba(0,0,0,0.36);background:url(https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/chatbot/chatadmin.jpg) no-repeat;background-size: 100% 100%;width:100px;height:100px;"><!--i class="zmdi zmdi-arrow-right"></i--></a>
                <p style="padding-top:0px;padding: 20px;color: #888;text-align: center;">Hi, Saya Admin MyCensus. Saya sedia chat dengan anda secara terus.  Bagaimana saya boleh membantu anda?</p>


            </div>

            <div id="chat_fullscreen" class="chat_conversion chat_converse">

            </div>

            <div id="footerstart" class="fab_field" style="background: #f4f4f4;border-top: 1px solid #ccc;">
                <a id="fab_camera" class="fab"><i class="fa fa-user"></i></a>
                <a id="fab_send_user_details" class="fab" data-toggle="tooltip" data-placement="top" title="Mulakan Sesi Chat!"><i class="fa fa-send"></i></a>
                <input type="text" id="btn-input-name" name="name" placeholder="Nama Penuh" class="chat_field chat_message input_chat" style="border: 1px solid #dedede;margin-bottom:0;">
                <input type="text" id="btn-input-email" name="email" placeholder="Alamat Emel" class="chat_field chat_message input_chat" style="border: 1px solid #dedede;margin-bottom:0;margin-top:0;">
                <input type="text" id="btn-input-phone" name="phone" placeholder="Nombor Telefon" class="chat_field chat_message input_chat" style="border: 1px solid #dedede;margin-top:0;">
                <!--textarea id="chatSend" name="chat_message" placeholder="Send a message" class="chat_field chat_message"></textarea-->
            </div>

            <div id="footerchat" class="fab_field" style="display:none;background: #f4f4f4;border-top: 1px solid #ccc;">
                <a id="fab_camera_chat" class="fab" data-toggle="tooltip" data-placement="top" title="Tamatkan Sessi Chat!"><i class="fa fa-times"></i></a>
                <a id="fab_send_chat" class="fab" data-toggle="tooltip" data-placement="top" title="Hantar!"><i class="fa fa-send"></i></a>
                <input type="text" id="chatmessage" name="chatmessage" placeholder="Pertanyaan Anda" class="chat_field chat_message input_chat" style="border: 1px solid #dedede;">
                <input type="hidden" id="questiontagid" value="">
                <!--textarea id="chatSend" name="chat_message" placeholder="Send a message" class="chat_field chat_message"></textarea-->
            </div>

            <div id="footerlive" class="fab_field" style="display:none;background: #f4f4f4;border-top: 1px solid #ccc;">
                <a id="fab_camera_chat_live" class="fab" data-toggle="tooltip" data-placement="top" title="Tamatkan Sesi Live Chat! Kembali ke chatbot"><i class="fa fa-times"></i></a>
                <a id="fab_send_chat_live" class="fab" data-toggle="tooltip" data-placement="top" title="Hantar Ke Admin"><i class="fa fa-send"></i></a>
                <input type="text" id="chatlive" name="chatlive" placeholder="Chat Secara Live" class="chat_field chat_message input_chat" style="border: 1px solid #dedede;">
                <!--textarea id="chatSend" name="chat_message" placeholder="Send a message" class="chat_field chat_message"></textarea-->
            </div>

        </div>
        <a id="prime" class="fab" style="z-index:-100;background-color:transparent;border-radius:0;box-shadow:none;background:url(https://chatbot.kpdnhep.gov.my/www/admin/files/kpdnhep/images/mainiconshadow.png) no-repeat;background-size: cover;">
            <!--i class="prime zmdi zmdi-comment-outline"></i-->

        </a>
    </div>
@stop

@section('javascript')
    <script>
        $(function () {

        })
    </script>
    <script src="{{ url('assets/chatbot/js/chatbot.js') }}"></script>
@stop
