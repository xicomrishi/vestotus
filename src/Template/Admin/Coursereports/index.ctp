<?= $this->Html->css('message'); ?>
<div class="message-area">
     <div class="left-section">
         <a class="user-role" href="javascript:void(0)"><h2 class="contact-heading">Courses <i class="fa fa-angle-down"></i></h2></a>
         <?php if(!empty($courses)){ ?>
         <ul class="contact-list">
             <?php foreach($courses as $course){ ?>
             <li id="<?= $course['id']; ?>" data-id="<?= $course['type'] ?>" class="courseelement <?= $course['id']; ?>"><a href="javascript:void(0)"><?= $course['title']; ?></a></li>
             <?php } ?>
         </ul>
         <?php } ?>
         
         
     </div>
     <div class="right-section">
        <div class="coursereportnavigation">

        </div>

        <div class="coursereportnavresults">
     </div>
    
   
</div>
<style>
.activeli{ background: ddd; color: greeen; }
</style>
<script>
$('.user-role').click(function(){
    $(this).next('.contact-list').slideToggle(); 
});

$(".courseelement").click(function(){

    $(this).addClass('activeli').siblings().removeClass('activeli');
    $(this).siblings().css({"background":"#e9e9e9", 'font-size':'13px'});
    //$('.contact-list li').removeClass('activeli');
    //$(this).addClass('activeli');
    $(".activeli").css({"background":"#cccccc", 'font-size':'15px'});
    $(".coursereportnavresults").html('');
    var courseid=$(this).attr('id');
    var coursetype= $(this).data('id');
    $.ajax({
        type: 'POST',
        url: siteUrl+'admin/coursereports/coursenavigation',
        data: { 
            'courseid': courseid,
            'coursetype': coursetype
        },
        success: function(msg){
            $(".coursereportnavigation").html(msg);
        }
    });
});

function doaction(id)
{
    if(id.indexOf("activity") != -1)
    {
        var courseid=id.replace(/[^0-9]/g,'');
        $.ajax({
            type: 'POST',
            url: siteUrl+'admin/courseactivity',
            data: { 
                'courseid': courseid
            },
            success: function(msg){
                $(".coursereportnavresults").html(msg);
            }
        });
    }
    else if(id.indexOf("enrollment") != -1)
    {
        var courseid=id.replace(/[^0-9]/g,'');
        $.ajax({
            type: 'POST',
            url: siteUrl+'admin/courseactivity/courseenrolls',
            data: { 
                'courseid': courseid
            },
            success: function(msg){
                $(".coursereportnavresults").html(msg);
            }
        });
    }/*
    else if(id.indexOf("editcourse") != -1)
    {

        var courseid=id.replace(/[^0-9]/g,'');
        var coursetype=$("#editcourse"+courseid).data('id');
        $.ajax({
            type: 'POST',
            url: siteUrl+'admin/courseactivity/editcourse',
            data: { 
                'courseid': courseid,
                'coursetype': coursetype
            },
            success: function(msg){
                //$(".coursereportnavresults").html(msg);
                alert(msg);
            }
        });

    }*/
    else if(id.indexOf("deselectcourse") != -1)
    {
        var courseid=id.replace(/[^0-9]/g,'');
        $(".courseelement").removeClass('activeli');
        $(".courseelement").css({"background":"#e9e9e9", 'font-size':'13px'});
        $(".coursereportnavigation").html('');
        $(".coursereportnavresults").html('');
    }
    else if(id.indexOf("enrolluser") != -1)
    {
        var courseid=id.replace(/[^0-9]/g,'');
        $.ajax({
            type: 'POST',
            url: siteUrl+'admin/courseactivity/enrolluserlist',
            data: { 
                'courseid': courseid
            },
            success: function(msg){
                $(".coursereportnavresults").html(msg);
            }
        });
    }
    else if(id.indexOf("deletecourse") != -1)
    {
        var courseid=id.replace(/[^0-9]/g,'');
        $.ajax({
            type: 'POST',
            url: siteUrl+'admin/courseactivity/deletecourse',
            data: { 
                'courseid': courseid
            },
            success: function(msg){
                $(".coursereportnavresults").html(msg);
            }
        });
    }
    else
    {
        alert("Bad request");
    }
}
</script>