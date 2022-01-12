function beep() {
    var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
    snd.play();
}

(function(){
  hideChat(0);


jQuery("#prime").click(function() {
  toggleFab();
});

jQuery("#faboverlaypurple").click(function() {
  toggleFab();
});


function hideChat(hide) {
    switch (hide) {
      case 0:
            jQuery("#chat_converse").css("display", "none");
            jQuery("#chat_body").css("display", "none");
            jQuery("#chat_form").css("display", "none");
            jQuery(".chat_login").css("display", "block");
            jQuery(".chat_fullscreen_loader").css("display", "none");
            jQuery("#chat_fullscreen").css("display", "none");
            break;
      case 1:
            jQuery("#chat_converse").css("display", "block");
            jQuery("#chat_body").css("display", "none");
            jQuery("#chat_form").css("display", "none");
            jQuery(".chat_login").css("display", "none");
            jQuery(".chat_fullscreen_loader").css("display", "block");
            var elem = document.getElementById("chat_converse");
            elem.scrollTop = elem.scrollHeight;
            break;
      case 2:
            jQuery("#chat_converse").css("display", "none");
            jQuery("#chat_body").css("display", "block");
            jQuery("#chat_form").css("display", "none");
            jQuery(".chat_login").css("display", "none");
            jQuery(".chat_fullscreen_loader").css("display", "block");
            var elem = document.getElementById("chat_body");
            elem.scrollTop = elem.scrollHeight;
            break;
      case 3:
            jQuery("#chat_converse").css("display", "none");
            jQuery("#chat_body").css("display", "none");
            jQuery("#chat_form").css("display", "block");
            jQuery(".chat_login").css("display", "none");
            jQuery(".chat_fullscreen_loader").css("display", "block");
            var elem = document.getElementById("chat_form");
            elem.scrollTop = elem.scrollHeight;
            break;
      case 4:
            jQuery("#chat_converse").css("display", "none");
            jQuery("#chat_body").css("display", "none");
            jQuery("#chat_form").css("display", "none");
            jQuery(".chat_login").css("display", "none");
            jQuery(".chat_fullscreen_loader").css("display", "block");
            jQuery("#chat_fullscreen").css("display", "block");
            var elem = document.getElementById("chat_fullscreen_loader");
            elem.scrollTop = elem.scrollHeight;
            var elem = document.getElementById("chat_fullscreen");
            elem.scrollTop = elem.scrollHeight;
            break;
    }
}


var toggleoverlay = false;

//Toggle chat and links
function toggleFab() {
  jQuery(".prime").toggleClass("zmdi-comment-outline");
  jQuery(".prime").toggleClass("zmdi-close");
  jQuery(".prime").toggleClass("is-active");
  jQuery(".prime").toggleClass("is-visible");
  jQuery("#prime").toggleClass("is-float");
  jQuery(".chat").toggleClass("is-visible");
  jQuery(".fab").toggleClass("is-visible");

  if (toggleoverlay) {
      //jQuery(".faboverlay").hide();
      toggleoverlay = false;
    } else {
      //jQuery(".faboverlay").show();
      toggleoverlay = true;
    }
  
  
}

  jQuery("#fab_send_user_details").click(function(e) {
        startChat();
  });

  jQuery("#fab_send_chat").click(function(e) {
        
        getChat();
  });

  jQuery("#fab_camera_chat_live").click(function(e) {
      endLiveChat();
        
  });

  jQuery("#fab_camera_chat").click(function(e) {
        logoutChat();
  });

  jQuery("#fab_send_chat_live").click(function(e) {
        getLive();
  });

  /*jQuery("#chat_fourth_screen").click(function(e) {
        hideChat(4);
        jQuery("#footerstart").show();
        jQuery("#footerchat").hide();
        jQuery("#footerlive").hide();
  });*/
  
  

  jQuery("#chat_fullscreen_loader").click(function(e) {
      jQuery(".fullscreen").toggleClass("zmdi-window-maximize");
      jQuery(".fullscreen").toggleClass("zmdi-window-restore");
      jQuery(".chat").toggleClass("chat_fullscreen");
      jQuery(".fab").toggleClass("is-hide");
      jQuery(".header_img").toggleClass("change_img");
      jQuery(".img_container").toggleClass("change_img");
      jQuery(".chat_header").toggleClass("chat_header2");
      jQuery(".fab_field").toggleClass("fab_field2");
      jQuery(".chat_converse").toggleClass("chat_converse2");
      
  });
  
  



var nameofuser = "";
var responsenumber = 1;
var panelcloseposition = 0;
var userregistered = 0;
var sessionid = "";

function showerror(errormessage){

    var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/chatbot/chatadmin.jpg\" style=\"border-radius: 50%;border: 1px solid #2d2c97;\"/></div>"+errormessage+"</span>";
        
  jQuery("#chat_converse").append(respondhtml); //Insert chat log into the #chatbox div  
      
  setTimeout(function(){
            var elem = document.getElementById("chat_converse");
                elem.scrollTop = elem.scrollHeight;
    },500);
}

function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validatePhone(phone) {
  const re =/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
  return re.test(phone);
}

function startChat(){
    
    jQuery(".chat").removeClass("chatheight");
    
    
    if ((jQuery("#btn-input-name").val()=="")||(jQuery("#btn-input-email").val()=="")||(jQuery("#btn-input-phone").val()=="")) {
        jQuery("#welcomemessage").html("<p style=\"color:red;\">Opps!.. Sila masukkan <span class=\"highlighttext\"><b>NAMA</b></span>, <span class=\"highlighttext\"><b>ALAMAT EMEL</b></span> dan <span class=\"highlighttext\"><b>NOMBOR TELEFON</b></span> anda untuk mulakan sesi!.</p>");

        jQuery("#btn-input-name").css("background-color","lemonchiffon");
        jQuery("#btn-input-email").css("background-color","lemonchiffon");
        jQuery("#btn-input-phone").css("background-color","lemonchiffon");
        
        beep();
    } else {

      if (!validateEmail(jQuery("#btn-input-email").val())) {
        beep();
          jQuery("#welcomemessage").html("<p style=\"color:red;\">Opps!.. Sila masukkan <span class=\"highlighttext\"><b>ALAMAT EMEL</b> (cth. abc@def.com)</span> yang betul untuk mulakan sesi!.</p>");
      } else {
          if (!validatePhone(jQuery("#btn-input-phone").val())) {
            beep();
              jQuery("#welcomemessage").html("<p style=\"color:red;\">Opps!.. Sila masukkan <span class=\"highlighttext\"><b>NOMBOR TELEFON</b> (cth. +601122334455)</span> yang betul untuk mulakan sesi!.</p>");
          } else {

          

      jQuery("#welcomemessage").html("<p style=\"color:#2d2c97;\">Memproses log masuk pengguna. Sila tunggu sebentar.</p><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/loadingdosm.gif\" style=\"width:100%;\">");
        
        jQuery("#btn-input-name").css("background-color","#fff");
        jQuery("#btn-input-email").css("background-color","#fff");
        jQuery("#btn-input-phone").css("background-color","#fff");
    
  
  jQuery.ajax({
      type: "POST",
    url: "https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/greeting-name",
    // url: "https://cors-anywhere.herokuapp.com/https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/greeting-name",
    data: {
        username: jQuery("#btn-input-name").val(),
        useremail: jQuery("#btn-input-email").val(),
        userphone: jQuery("#btn-input-phone").val()
    },
    cache: false,
    success: function(html){
        
        //alert(jQuery("#btn-input-name").val());
        
        //alert(JSON.stringify(html));
        
        nameofuser = jQuery("#btn-input-name").val();
        userregistered = 1;
        
        var respondtext = "";
        var dt = "";
        
        //alert(JSON.stringify(html));
        
        if (JSON.stringify(html)!="") {
            
        
            respondtext = html.data.message;
            sessionid = html.data.sessionid;
            dt = html.response_date_time;
            
             
        }
        
       

        var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/kpdnhep/images/chaticon.png\" style=\"border-radius: 50%;\"/></div>"+respondtext+"<p style=\"font-size:0.8em;text-align:right;padding-top: 10px;margin-bottom: 0;\"><i class=\"fa fa-clock-o\"></i> "+dt+"</p></span>";
        
        jQuery("#chat_converse").append(respondhtml); //Insert chat log into the #chatbox div  
      
        setTimeout(function(){
            var elem = document.getElementById("chat_converse");
                elem.scrollTop = elem.scrollHeight;
        },500);
      
        
   
        jQuery("#btn-input-name").val("");
        jQuery("#btn-input-email").val("");
        jQuery("#btn-input-phone").val("");
        
        panelcloseposition = 1;

        hideChat(1);
        jQuery("#footerstart").hide();
        jQuery("#footerchat").show();
        jQuery("#footerlive").hide();
        
        
        
      },
  });

        }
      }
  
    }
}

function getChat(){ 

    if (sessionid == "") {
        logoutChat();
    } else {
    
    var questionmsg = jQuery("#chatmessage").val();
    
    
    var questionhtml = "<span class=\"chat_msg_item chat_msg_item_user\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my//www/admin/files/dosm/images/chatbot/chatuserorange.png\" style=\"padding-bottom: 4px;\"/></div>"+questionmsg+"</span>";
        
  jQuery("#chat_converse").append(questionhtml); //Insert chat log into the #chatbox div 
      
            
    jQuery("#chatmessage").val("");
    
    var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my//www/admin/files/kpdnhep/images/chaticon.png\" style=\"border-radius: 50%;\"/></div><div id=\"message"+responsenumber+"\" style=\"margin:0;padding:0;\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/loadingdosm.gif\" style=\"width:100%;\"></div><p style=\"font-size:0.8em;text-align:right;padding-top: 10px;margin-bottom: 0;\"><span id=\"messagedt"+responsenumber+"\"></span></p></span>";
  
  jQuery("#chat_converse").append(respondhtml); //Insert chat log into the #chatbox div  
      
  setTimeout(function(){
            var elem = document.getElementById("chat_converse");
                elem.scrollTop = elem.scrollHeight;
    },500);
    
    
    if (questionmsg.includes("live chat")){
        initLiveChat();
        
    } else {
    
  
  jQuery.ajax({
      type: "POST",
    url: "https://chatbot.kpdnhep.gov.my/www/index.php?r=chat/question",
    // url: "https://cors-anywhere.herokuapp.com/https://chatbot.kpdnhep.gov.my/www/index.php?r=chat/question",
    data: {
        question: questionmsg,
        sessionid : sessionid
    },
    cache: false,
    success: function(html){
        
         console.log(JSON.stringify(html));
         userregistered = 1;
        
        var respondtext = "";
       
        var dt = "";
        
        if (JSON.stringify(html)!="") {
            respondtext = html.data.message;
            dt = "<i class=\"fa fa-clock-o\"></i> "+html.response_date_time;
            if (parseInt(html.data.question_tag_id)>0) {
                jQuery("#questiontagid").val(html.data.question_tag_id);
                jQuery("#footerstart").hide();
                    jQuery("#footerchat").hide();
                    //jQuery("#footeranswer").show();
                    jQuery("#footerlive").hide();
            } else {
                jQuery("#footerstart").hide();
                    jQuery("#footerchat").show();
                    //jQuery("#footeranswer").hide();
                    jQuery("#footerlive").hide();
            }
            
           
        
            if (html.data.suggestion_status===true) {
                if (typeof html.data.suggestion === "undefined") {
                    
                } else {
                    if (html.data.suggestion.length>0) {
                        for (var i=0;i<html.data.suggestion.length;i++) {
                        respondtext += "<hr>"+html.data.suggestion[0].description;
                        }
                    } else {
                        respondtext += "<hr>"+html.data.suggestion.suggestion_description;
                    }
                }
            }
            
           
        
            
            
            
        }
        
        
       
        setTimeout(function(){
        
        jQuery("#message"+responsenumber).html(respondtext);
        jQuery("#messagedt"+responsenumber).html(dt);
        
        responsenumber++;
        
        },500);
        
        setTimeout(function(){
            var elem = document.getElementById("chat_converse");
                elem.scrollTop = elem.scrollHeight;
        
        },600);
        
        
        
            

      },
  });
  
    }
  
    }
}

function logoutChat(){  
    
    jQuery("#btn-input-name").val("");
    jQuery("#btn-input-email").val("");
    jQuery("#btn-input-phone").val("");
    
  jQuery.ajax({
      type: "POST",
      url: "https://chatbot.kpdnhep.gov.my/www/index.php?r=chat/user-bye",
      // url: "https://cors-anywhere.herokuapp.com/https://chatbot.kpdnhep.gov.my/www/index.php?r=chat/user-bye",
      data: {
        sessionid : sessionid
    },
    
    cache: false,
    success: function(html){
        
         //alert(JSON.stringify(html));
         userregistered = 0;
        
        var respondtext = "";
        var dt = "";
        
        if (JSON.stringify(html)!="") {
            respondtext = html.data;
            dt = html.response_date_time;
        }
        
        var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\" style=\"background: beige;\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/kpdnhep/images/chaticon.png\" style=\"border-radius: 50%;\"/></div>"+respondtext+"<p style=\"font-size:0.8em;text-align:right;padding-top: 10px;margin-bottom: 0;\"><i class=\"fa fa-clock-o\"></i> "+dt+"</p></span>";
        
            jQuery("#chat_converse").append(respondhtml); //Insert chat log into the #chatbox div  
            
            var elem = document.getElementById("chat_converse");
            elem.scrollTop = elem.scrollHeight;
      

            jQuery("#btn-input-name").val("");
            jQuery("#btn-input-email").val("");
            jQuery("#btn-input-phone").val("");
            
            
            
            panelcloseposition = 0;
            
            sessionid = "";
            
            beep();
            
            setTimeout(function(){
                jQuery(".chat").removeClass("chat_fullscreen");
                jQuery(".chat_converse").removeClass("chat_converse2");
                
                jQuery(".prime").addClass("is-active");
                jQuery(".prime").addClass("is-visible");
                jQuery("#prime").addClass("is-float");
                jQuery("#prime").removeClass("is-hide");
                
                jQuery("#welcomemessage").html("Selamat Datang <b>Pengguna</b>, sila masukkan <b>Nama</b>, <b>Nombor Telefon</b> dan <b>Alamat Emel</b> untuk memulakan sesi chat.");
       
                
                hideChat(0);
                jQuery("#footerstart").show();
                jQuery("#footerchat").hide();
                jQuery("#footerlive").hide();
            },2000);
            
            
      },
  });
}

function initLiveChat() {
    console.log("chat_start");
    if (userregistered == 0) {
        var respondtext = "Opps! Anda belum daftar. Sila masukkan nama, alamat emel dan nombor telefon untuk mendaftar";
        
        var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\" style=\"background: beige;\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my//www/admin/files/kpdnhep/images/chaticon.png\" style=\"border-radius: 50%;\"/></div>"+respondtext+"<p style=\"font-size:0.8em;text-align:right;padding-top: 10px;margin-bottom: 0;\"><i class=\"fa fa-clock-o\"></i> "+dt+"</p></span>";
        
            jQuery("#chat_converse").append(respondhtml); //Insert chat log into the #chatbox div  
            
            var elem = document.getElementById("chat_converse");
            elem.scrollTop = elem.scrollHeight;
        
           setTimeout(function(){
                jQuery(".chat").removeClass("chat_fullscreen");
                jQuery(".chat_converse").removeClass("chat_converse2");
                
                jQuery(".prime").addClass("is-active");
                jQuery(".prime").addClass("is-visible");
                jQuery("#prime").addClass("is-float");
                jQuery("#prime").removeClass("is-hide");
                
                jQuery("#welcomemessage").html("Selamat Datang <b>Pengguna</b>, sila masukkan <b>Nama</b>, <b>Nombor Telefon</b> dan <b>Alamat Emel</b> untuk memulakan sesi chat.");
       
                
                hideChat(0);
                jQuery("#footerstart").show();
                jQuery("#footerchat").hide();
                jQuery("#footerlive").hide();
            },2000);
    } else {
        beep();
        
        hideChat(3);
        jQuery("#footerstart").hide();
        jQuery("#footerchat").hide();
        jQuery("#footerlive").show();
        
        initLiveChatToAdmin();
    }
}

function initLiveChatToAdmin(){ 

    if (sessionid == "") {
        logoutChat();
    } else {
    
  
  jQuery.ajax({
      type: "POST",
    url: "https://chatbot.kpdnhep.gov.my/www/index.php?r=chat/live-chat-init",
    // url: "https://cors-anywhere.herokuapp.com/https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/greeting-name",
    data: {
        sessionid : sessionid
    },
    cache: false,
    success: function(html){
        
         console.log(JSON.stringify(html));
         userregistered = 1;
        
        var respondtext = "";
        var dt = "";
        
        if (JSON.stringify(html)!="") {
            respondtext = "Sesi Live Chat telah dimulakan.  Sila masukkan persoalan anda dan tunggu jawapan dari kami.";
            
             if (typeof html.data === "undefined") {
                    
             } else {
                respondtext = html.data;
             }
            
            dt = html.response_date_time;
                           
                jQuery("#footerstart").hide();
                    jQuery("#footerchat").hide();
                    jQuery("#footeranswer").hide();
                    jQuery("#footerlive").show();
            
        }
        
        
        var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/chatbot/chatadmin.jpg\" style=\"border-radius: 50%;border: 1px solid #2d2c97;\"/></div>"+respondtext+"<p style=\"font-size:0.8em;text-align:right;padding-top: 10px;margin-bottom: 0;padding-top: 10px;margin-bottom: 0;\"><i class=\"fa fa-clock-o\"></i> "+dt+"</p></span>";
        
        
            jQuery("#chat_form").append(respondhtml); 
      
        
        setTimeout(function(){
            var elem = document.getElementById("chat_form");
                elem.scrollTop = elem.scrollHeight;
            },500);
        
            responsenumber++;
            
            chaton = true;

      },
  });
  
    }
}

function getLive(){ 

    if (sessionid == "") {
        logoutChat();
    } else {
    
    var questionmsg = jQuery("#chatlive").val();
    
    var questionhtml = "<span class=\"chat_msg_item chat_msg_item_user\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/chatbot/chatuserorange.png\" style=\"padding-bottom: 4px;\"/></div>"+questionmsg+"</span>";
  
    
    //var questionhtml = "<div class=\"row msg_container base_receive\"><div class=\"col-md-2 col-xs-2 avatar\"><img src=\"https://chatbot.kpdnhep.gov.my//www/admin/files/dosm/images/icon-user.png\" class=\" img-responsive \" style=\"border-radius:50%;\"></div><div class=\"col-xs-10 col-md-10\" style=\"padding-left: 0;\"><div class=\"messages msg_receive\" style=\"background: oldlace;border:5px solid #fff;\"><p>"+questionmsg+"</p><time datetime=\"\">"+nameofuser+" • 0 min</time></div></div></div>";
        
  jQuery("#chat_form").append(questionhtml); //Insert chat log into the #chatbox div 
      

            
    jQuery("#chatlive").val("");
    
    //var respondhtml = "<div class=\"row msg_container base_sent\"><div class=\"col-md-10 col-xs-10\" style=\"padding-right: 0;\"><div class=\"messages msg_sent\"><div id=\"message"+responsenumber+"\" style=\"margin:0;padding:0;\"><img src=\"https://chatbot.kpdnhep.gov.my//www/admin/files/dosm/images/loadingdosm.gif\" style=\"width:100%;\"></div><time datetime=\"\">Admin • 0 min</time></div></div><div class=\"col-md-2 col-xs-2 avatar\"><img src=\"admin/files/dosm/images/icon-dosm2.png\" class=\" img-responsive \" style=\"border-radius:50%;\"></div></div>";
  
  var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/chatbot/chatadmin.jpg\" style=\"border-radius: 50%;border: 1px solid #2d2c97;\"/></div><div id=\"messagelive"+responsenumber+"\" style=\"margin:0;padding:0;\"><img src=\"https://chatbot.kpdnhep.gov.my//admin/files/dosm/images/loadingdosm.gif\" style=\"width:100%;\"></div></span>";
        
        
  jQuery("#chat_form").append(respondhtml); //Insert chat log into the #chatbox div  
      
  setTimeout(function(){
            var elem = document.getElementById("chat_form");
                elem.scrollTop = elem.scrollHeight;
    },500);
    
    
  
  jQuery.ajax({
      type: "POST",
    url: "https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/live-chat",
    // url: "https://cors-anywhere.herokuapp.com/https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/live-chat",
    data: {
        chat: questionmsg,
        sessionid : sessionid
    },
    cache: false,
    success: function(html){
        
         //alert(JSON.stringify(html));
         userregistered = 1;
        
        var respondtext = "";
        
        if (JSON.stringify(html)!="") {
            respondtext = "<img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/writing.gif\" style=\"width:50%;\">";
            
                jQuery("#footerstart").hide();
                    jQuery("#footerchat").hide();
                    //jQuery("#footeranswer").hide();
                    jQuery("#footerlive").show();
            
        }
        
        jQuery("#messagelive"+responsenumber).html(respondtext);
        
        setTimeout(function(){
            var elem = document.getElementById("chat_form");
                elem.scrollTop = elem.scrollHeight;
            },500);
            
            if (chaton) {
                loopLiveChat(responsenumber);
            }
        
            responsenumber++;

      },
  });
  
    }
  
    
}

function endLiveChat(){ 

    
        
        chaton = false;
    
    showerror("Terima kasih kerana chat secara live dengan pentadbir kami");
    
    var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/chatbot/chatadmin.jpg\" style=\"border-radius: 50%;border: 1px solid #2d2c97;\"/></div>Terima kasih kerana chat secara live dengan kami</span>";
        
        
        jQuery("#chat_form").append(respondhtml); 
      
        
    setTimeout(function(){
            var elem = document.getElementById("chat_form");
                elem.scrollTop = elem.scrollHeight;
            },500);
        
        setTimeout(function(){
            
        hideChat(1);
            jQuery("#footerstart").hide();
            jQuery("#footerchat").show();
            jQuery("#footerlive").hide();
        
        },2000);
        
  
        for (var i=0;i<responsenumber+1;i++) {
            clearInterval(myInterval[i]);
        }

        
}

var myInterval = [];
var responsenumberlocal = 0;
var chaton = false;

function loopLiveChat(rn) {
    responsenumberlocal = rn;
    myInterval[rn] = setInterval(checkResponse, 10000);
}

function checkResponse(){ 
    
  jQuery.ajax({
      type: "POST",
    url: "https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/live-chat",
    // url: "https://cors-anywhere.herokuapp.com/https://chatbot.kpdnhep.gov.my//www/index.php?r=chat/live-chat",
    data: {
        chat: "",
        sessionid : sessionid
    },
    cache: false,
    success: function(html){
        
         console.log(JSON.stringify(html));
         userregistered = 1;
        
        var respondtext = "";
        
        if (JSON.stringify(html)!="") {
            respondtext = "receiving data";
            dt = "";
            
                jQuery("#footerstart").hide();
                    jQuery("#footerchat").hide();
                    //jQuery("#footeranswer").hide();
                    jQuery("#footerlive").show();
                
                if (html.data.length != undefined && html.data.length != 0) {
                    respondtext = "";
                    
                    if (typeof html.data === "undefined") {
                    
                    } else {
                
                        if (Array.isArray(html.data)) {
                            for (var i=0;i<html.data.length;i++) {
                                respondtext += html.data[i].live_message + "<br><br>";
                            }
                        } else {
                            respondtext = html.data;
                        }
                    
                    }
                    
                    if ( responsenumberlocal != 0) {
                        jQuery("#message"+responsenumberlocal).html(respondtext);
                    } else {
                        
                         var respondhtml = "<span class=\"chat_msg_item chat_msg_item_admin\"><div class=\"chat_avatar\"><img src=\"https://chatbot.kpdnhep.gov.my//www/admin/files/dosm/images/chatbot/chatadmin.jpg\" style=\"border-radius: 50%;border: 1px solid #2d2c97;\"/></div><div id=\"messagelive"+responsenumber+"\" style=\"margin:0;padding:0;\"><img src=\"https://chatbot.kpdnhep.gov.my/www/admin/files/dosm/images/loadingdosm.gif\" style=\"width:100%;\"></div></span>";
        
        
                        jQuery("#chat_form").append(respondhtml); 
      
        
                    
                    
                        
      
                      responsenumberlocal = responsenumber;
                      
                      jQuery("#messagelive"+responsenumberlocal).html(respondtext);
                      
                      console.log("#messagelive"+responsenumberlocal);
                      
                      setTimeout(function(){
                        var elem = document.getElementById("chat_form");
                            elem.scrollTop = elem.scrollHeight;
                        },500);
                      
                      responsenumber++;
                        
                    }
                   
        
                var elem = document.getElementById("chat_form");
                    elem.scrollTop = elem.scrollHeight;
                    
                    responsenumberlocal = 0;
                    
                    
                }
            
        }
        


      },
  });
}

})();