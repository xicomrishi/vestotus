<div class="col-md-9 col-sm-12 page-left-sidebar catalog" id="sidebar">
 <div class="widget clearfix">
                            <div class="member-profile">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Calendar </span>
                                    </h2>
                                </div><!-- end big-title -->
 		<div id="calendar"> </div>
                            </div><!-- end team-member -->
                        </div>
</div>
<?= $this->Html->css('../plugins/fullcalendar/fullcalendar.css') ?>
<?= $this->Html->script('../plugins/fullcalendar/lib/moment.min.js') ?>
<?= $this->Html->script('../plugins/fullcalendar/fullcalendar.js') ?>


<script type="text/javascript">
	$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
    })

});
</script>