<?php
$template = 'master';

include($_SERVER['DOCUMENT_ROOT']."/includes/bootstrap.php");

function page()
{
    page_title("Press Calendar");

    print "<div id='quickjump' style='z-index:30000;'>\n";
    if($_GET['qdate'])
    {
        $qdate=$_GET['qdate'];
    } else {
        $qdate=date("Y-m-d",strtotime("+1 week"));
    }

    //lets make a drop down with a list of the next 52 weeks in it with starting dates
    //calculate the date that is "sunday" for the current week
    $startdate=date("Y-m-d");


    while (date("w",strtotime($startdate))!=0)
    {
        $startdate=date("Y-m-d",strtotime($startdate."-1 day"));
    }
    $basedate=$startdate;
    $year=date("Y",strtotime($basedate));
    $month=date("m",strtotime($basedate));
    $date=date("d",strtotime($basedate));

    print "Select a week to jump to: <select id='quickdate' onChange='jumpDate(this.value);'>";

    for($i=7;$i>0;$i--)
    {
        $backdate=date("Y-m-d",strtotime($startdate."-$i weeks"));
        print "<option id='$backdate' value='$backdate'>$backdate</option>\n";
    }
    for($i=1;$i<53;$i++)
    {
        if($i==1){$selected='selected';}else{$selected='';}
        print "<option id='$startdate' value='$startdate' $selected>$startdate</option>\n";
        $startdate=date("Y-m-d",strtotime($startdate."+1 week"));
    }
    print "</select>";

    print "<div id='calendar'></div>";

    print "<div id='unscheduled' class='row'>\n";
    print "<div class='col-md-10 col-md-offset-1 col-xs-12'>
       <div class=\"panel panel-primary\">
      <div class=\"panel-heading\">Unscheduled Jobs</div>
      <div class=\"panel-body unscheduledHolder\">

      </div>
    </div>
      </div>
</div>\n";

    //@TODO build up available actions for this user based on their permissions
    $contextMenuActions="
            \"print\": {name: \"Print Job Ticket\"},
            \"edit\": {name: \"Edit Job\"},
            \"printstacker\": {name: \"Print Stacker Ticket\"},
            \"recurrence\": {name: \"Edit Recurrence\"},
            \"press\": {name: \"View in Press Monitor\"},
            \"pagination\": {name: \"View in Pagination Monitor\"},
            \"plateroom\": {name: \"View in Plateroom Monitor\"},
            \"unschedule\": {name: \"Un-schedule Job\"},
            \"delete\": {name: \"Delete Job\"}
    ";
$calendarScript = <<<CALSCRIPT
    $.contextMenu({
        selector: '.fc-event',
        callback: function(key, options) {
            handlePressContextMenu(options.\$trigger.data("id"),key);
        },
        items: {
           $contextMenuActions
        }
    });
    var tooltip = \$('<div/>').qtip({
        id: 'calendar',
        prerender: false,
        content: {
            text: ' ',
            title: {
                button: true
            }
        },
        position: {
            my: 'bottom center',
            at: 'top center',
            target: 'event',
        },
        show: {
            event: 'mouseenter',
            solo: true,
            delay: 500
        },
        hide: false,
        style: 'qtip-light'
    }).qtip('api');

   var calendarStartPress=6;
   var calendarPressSlots=15;
   var calendarSchedulePress=true;
   if(calendarSchedulePress)
   {
       var disableDrag=false;
   } else {
       var disableDrag=true;
   }

   var wWidth=\$(window).width();
   var defaultAgenda='agendaWeek';
   if (wWidth<950)
   {
       defaultAgenda= 'agendaDay';
   }


   \$('#calendar').fullCalendar({
       firstHour: calendarStartPress,
       slotMinutes: calendarPressSlots,
       header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        slotEventOverlap: false,
        disableDragging: disableDrag,
        defaultView: defaultAgenda,
        events: {
            url: '/ajax/calendar/press.php',
            type: 'POST',
            error: function() {
                console.log("Error fetching calendar events from the database");
            }
        },
        height: \$(window).height()-190,
        windowResize: function(view) {
            if (\$(window).width()<950)
            {
                \$(this).fullCalendar( 'changeView', 'agendaDay');
            } else {
                \$(this).fullCalendar( 'changeView', 'agendaWeek');
            }
            \$(this).fullCalendar( 'option', 'height', \$(window).height()-190);

        },
        eventDrop: function(event,delta,revertFunc) {
            tooltip.hide();
            var data =  {days:delta.days(),hours:delta.hours(),minutes:delta.minutes()};
            //ajaxCall('/calendar/'+event.id+'/move',data,null,revertFunc);

       },
       eventResize: function(event, delta, revertFunc) {
           tooltip.hide();
           var data =  {hours:delta.hours(),minutes:delta.minutes()};
           //ajaxCall('/calendar/'+event.id+'/resize',data,null,revertFunc);
       },

       loading: function(bool) {
           if (bool) \$('#loading').show();
           else \$('#loading').hide();
       },
       eventClick: function(data, event, view) {
           currentJobID=event.id;
       },
       eventMouseover: function(data, event, view) {
           \$(this).css('border-color','red');
           currentJobID=event.id;
           var content = '<h3>'+data.title+'</h3>' +
                   '<p><b>Start:</b> '+data.start+'<br />' +
                   '<p><b>End:</b> '+data.end+'</p>' +
                   '<p><b>Description:</b> '+data.description+'</p>';

           tooltip.set({
               'content.text': content
           }).reposition(event).show(event);
       },
       eventMouseout: function( event, jsEvent, view ) {
           //tooltip.hide();
           \$(this).css('border-color',event.color);
       },

       dayClick: function(date, allDay, jsEvent, view) {
           tooltip.hide();
       },

       eventRender: function(event, element) {
           element.data('id',event.id);
           element.data('invokedOn',event.id);
           element.bind('dblclick', function() {
               loadJob(event.id);
           });
       },
       droppable: true,
       drop: function(date, allDay) {
           //we'll update the record via ajax, then refresh the calendar...
           var jobid=\$(this).attr('id');
           \$.ajax({
               url: 'includes/ajax_handlers/updateCalendarPress.php',
               type: "POST",
               data: {type:'drop',jobid:jobid,date:date,},
               dataType: 'json',
               success: function(response) {
                   if(response.status=='success')
                   {
                       \$('#calendar').fullCalendar('refetchEvents');
                   } else {
                       var message = {'message':response.message,'type':'smallBox','title':"Job Scheduling failed",'color':'red'};
                       //showMessage(message);
                   }
               }
           });
           $(this).remove();
       },
       viewDisplay: function(view) {
           var d= new Date();
           var curDate = Date.parse(view.start);
           d.setTime(curDate);
           var curMonth = d.getMonth()+1;
           var curDay   = d.getDate();
           var curYear  = d.getFullYear();
           //getUnscheduled(curYear,curMonth,curDay)
           //console.log('The new title of the view is ' + view.title+' and the start date is '+curMonth+'/'+curDay+'/'+curYear);
       }

    })

    function refreshCalendar()
    {
       $('#calendar').fullCalendar('refetchEvents');
    }
    function jumpDate(cdate)
    {
        var temp=cdate.split("-");
        var year=temp[0];
        var month=temp[1];
        var date=temp[2];
        month=parseInt(month)-1;
        $('#calendar').fullCalendar('gotoDate', year, month, date);
        //getUnscheduled(year,month,date);  // this is now integrated into the viewDisplay event in full calendar
    }


    function getUnscheduled(year,month,date)
    {
        //console.log('getting unscheduled events with date='+month+'/'+date+'/'+year);
        $.ajax({
           url: 'includes/ajax_handlers/updateCalendarPress.php',
           type: "POST",
           data: "type=unscheduled&year="+year+"&month="+month+"&date="+date,
           dataType:'json',
           success: function(response) {
               if(response.status=='success')
               {
                   $('.unscheduledHolder').empty();
                   $.each(response.jobs, function (j,job){
                      var newDiv=$('<div id="'+job.id+'"><span id="pop'+job.id+'" style="float:right;"><img src="/artwork/icons/magnifying-glass.png" border=0 height=20 /></span>'+job.title+'</div>').addClass('ui-widget ui-draggable unscheduledJob');
                      var eventObject = {
                            title: job.title // use the element's text as the event title
                      };
                      // store the Event Object in the DOM element so we can get to it later
                      $(newDiv).data('eventObject', eventObject);
                      var dHolder=$('#'+job.dateholder);

                      $('#'+job.dateholder).append(newDiv);
                      $('#pop'+job.id).qtip({
                            content: {
                                text: job.tooltip,
                                title: {
                                  text: 'Job Details',
                                  button: '<span onclick="return false;">Close</span>'
                                }
                            },
                            position: {
                                    target: $('#pop'+job.id),
                                    my: 'left center',
                                    at: 'right center'
                                },
                            style: {
                                classes: 'ui-tooltip-shadow', // Optional shadow...
                                tip: 'left center' // Tips work nicely with the styles too!
                            },
                            show: {
                                event: 'click',
                                solo: true // Only show one tooltip at a time
                            },
                            hide: 'unfocus'
                        });

                      //console.log('added new div '+job.id);
                      // make the event draggable using jQuery UI
                      $(newDiv).draggable({
                          zIndex: 999,
                          revert: true,      // will cause the event to go back to its
                          revertDuration: 0  //  original position after the drag
                      });

                  });


               } else {
                  alertMessage("Job sheduling failed<br />"+res,'error');
               }
           }
        });

    }

    function loadJob(id)
    {
        console.log('loading job');
    }

    function handlePressContextMenu(id,action)
    {
        console.log("called "+action+" on jobid="+id);
        switch(action)
        {
            case "print":
               window.open('/print_templates/press/jobPressTicket.php?action=print&jobid='+id,'Press Job Ticket',"scrollbars=0, resizeable=1, width=750, height=640");
            break;

            case "edit":
                if(calendarSchedulePress && event.mypub)
                {
                    window.open('pages/press/job.php?id='+event.id,'Press Job Editor',"scrollbars=0, resizeable=1, width=900, height=850");
                } else {
                    window.open('pages/press/job.php?id='+event.id+'&ne=true','Press Job Editor',"scrollbars=0, resizeable=1, width=900, height=850");
                }
            break;

            case "printstacker":
                window.open('/print_templates/press/pressStackerTicket.php?jobid='+id,'Press Stacker Ticket',"scrollbars=0, resizeable=1, width=750, height=640");
            break;

            case "recurrence":
                if(calendarSchedulePress && event.mypub)
                {
                   window.open('jobRecurring.php?action=edit&recurringid='+event.recurringid,'Recurring Job Editor',"scrollbars=0, resizeable=1, width=750, height=640");
                } else {
                   var message ={ title:"Permission Denied",
                                  content: "You do not have permission to edit this recurrence",
                                  color: "ff0000",
                                  timeout: "3"
                                }
                   showMessage(message);
                }
            break;

            case "press":
                window.location='/pages/monitor/press.php?id='+id;
            break;

            case "pagination":
                window.location='/pages/monitor/pagination.php?id='+id;
            break;

            case "plateroom":
                window.location='/pages/monitor/plateroom.php?id='+id;
            break;

            case "unschedule":

            break;

            case "delete":

            break;
        }

        /*

        'Un-schedule Job': {
            click: function(element){ // element is the jquery obj clicked on when context menu launched
                if(calendarSchedulePress && event.mypub)
                {
                    var a = this;
                    var d= new Date();
                    var month=d.getMonth()+1;
                    var date=d.getDate();
                    var year=d.getFullYear();
                    var today=month+"/"+date+"/"+year;
                    var diagHtml="<p>This job will be removed from the schedule if you click ok. Please enter a new requested print date:<br>";
                    diagHtml+="<input type='text' id='rdate_"+event.id+"' value='' placeholder='"+today+"'/></p>";

                    var \$dialog = $('<div id="jConfirm"></div>')
                    .html(diagHtml)
                    .dialog({
                        autoOpen: true,
                        title: 'Unschedule Job',
                        draggable: false,
                        modal: true,
                        buttons: {
                            Cancel: function() {
                                $( this ).dialog( "destroy" );
                                return false;
                            },
                            'Unschedule': function() {
                                var requestdate=$('#rdate_'+event.id).val();
                                $( this ).dialog( "destroy" );
                                $.ajax({
                                   url: 'includes/ajax_handlers/updateCalendarPress.php',
                                   type: "POST",
                                   data: {type:'unschedule',jobid:event.id,dayDelta:0,minuteDelta:0,rdate:requestdate},
                                   dataType: 'json',
                                   success: function(response) {
                                       if(response.status=='success')
                                       {
                                            $('#calendar').fullCalendar( 'removeEvents',event.id );
                                            var view = $('#calendar').fullCalendar('getView');
                                            var d= new Date();
                                            var curDate = Date.parse(view.start);
                                            d.setTime(curDate);
                                            var curMonth = d.getMonth()+1;
                                            var curDay   = d.getDate();
                                            var curYear  = d.getFullYear();
                                            getUnscheduled(curYear,curMonth,curDay);
                                       } else {
                                          alertMessage("Job unscheduling failed<br />"+response.status+'<br>'+response.message,'error');
                                       }
                                   }
                               });
                            }
                        },
                        open: function() {
                            $('#rdate_'+event.id).datepicker({ dateFormat: 'mm/dd/yy' });
                            $('.ui-dialog-buttonpane > button:last').focus();
                            $('#rdate_'+event.id).click(function(){\$('#rdate_'+event.id).datepicker( "show" );})
                        }

                    });
                    //a.dialog("open");
               } else {
                   noPerms('edit');
               }
            }
        },
        'Delete Job': {
           click: function(element){ // element is the jquery obj clicked on when context menu launched
                if(calendarSchedulePress && event.mypub)
                {
                    var a = this;
                    var \$dialog = $('<div id="jConfirm"></div>')
                    .html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>')
                    .dialog({
                        autoOpen: true,
                        title: 'Are you sure you want to Delete?',
                        draggable: false,
                        modal: true,
                        buttons: {
                            Cancel: function() {
                                $( this ).dialog( "close" );
                                return false;
                            },
                            'Delete': function() {
                              $( this ).dialog( "close" );
                                $.ajax({
                                   url: 'includes/ajax_handlers/updateCalendarPress.php',
                                   type: "POST",
                                   data: {type:'delete',jobid:event.id,dayDelta:0,minuteDelta:0},
                                   dataType: 'json',
                                   success: function(response) {
                                       if(response.status=='success')
                                       {
                                            $('#calendar').fullCalendar( 'removeEvents',event.id );

                                       } else {
                                            alertMessage("Job deletion failed<br />"+response.status+'<br>'+response.sql,'error');
                                       }
                                   }
                               });
                            }
                        },
                        open: function() {
                            $('.ui-dialog-buttonpane > button:last').focus();
                        }

                    });
                    //a.dialog("open");
               } else {
                   noPerms('delete');
                }
            }
        }
        */
    }

CALSCRIPT;
    $GLOBALS['scripts'][]=$calendarScript;

    /*
     *
        from event move
            if(calendarSchedulePress && event.mypub)
           {
               if(event.eventtype=='maintenance')
               {
                   \$.ajax({
                       url: 'includes/ajax_handlers/maintenanceScheduledTicketHandler.php',
                       type: "POST",
                       data: {type:'move',scheduleid:event.id,dayDelta:dayDelta,minuteDelta:minuteDelta},
                       dataType: 'json',
                       error: function()
                       {
                           revertFunc();
                       },
                       success: function(response) {
                           if(response.status=='success')
                           {
                               //don't do anything to annoy the user with a dialog or somethign :)
                           } else {
                               var message = {'message':response.message,'type':'smallBox','title':"Job Update failed",'color':'red'};
                               showMessage(message);
                               revertFunc();
                           }
                       }
                   });
               } else {
                   \$.ajax({
                       url: 'includes/ajax_handlers/updateCalendarPress.php',
                       type: "POST",
                       data: {type:'move',jobid:event.id,dayDelta:dayDelta,minuteDelta:minuteDelta},
                       dataType: 'json',
                       error: function()
                       {
                           revertFunc();
                       },
                       success: function(response) {
                           if(response.status=='success')
                           {
                               //don't do anything to annoy the user with a dialog or somethign :)
                           } else {
                               var message = {'message':response.message,'type':'smallBox','title':"Job Update failed",'color':'red'};
                               showMessage(message);
                               revertFunc();
                           }
                       }
                   });
               }
           }


    from dayclick

           if(view.name=='month')
           {
               \$('#calendar').fullCalendar(
                       'changeView','agendaDay'
               );
               \$('#calendar').fullCalendar(
                       'gotoDate', date
               );

           } else {
               if(calendarSchedulePress)
               {
                   var addMessage='This will create a new press job. Are you sure?';
                   var addTitle = "Are you sure you want to create a new job?";
                   var myButtons = {
                       Cancel: function() {
                           \$( this ).dialog( "close" );
                           return false;
                       },
                       'Create Job': function() {
                           \$( this ).dialog( "close" );
                           \$.ajax({
                               url: 'includes/ajax_handlers/updateCalendarPress.php',
                               type: "POST",
                               data: {type:'add',jobid:0,dayDelta:0,minuteDelta:0,date:date},
                               dataType: 'json',
                               success: function(response) {
                                   if(response.status=='success')
                                   {
                                       window.open('jobPressPopup.php?id='+response.jobid,'Press Job Editor',"scrollbars=1, resizeable=1, width=940, height=900");
                                   } else {
                                       var message = {'message':response.message,'type':'smallBox','title':"Job Creation failed",'color':'red'};
                                       showMessage(message);
                                   }
                               }
                           });
                       }
                   }
                   if (minPressCalendarJobAddDate > date)
                   {
                       //means we are trying to schedule a job earlier than earliest allowed
                       var showDate=String(minPressCalendarJobAddDate).split(" GMT");
                       addTitle='Scheduled date/time not allowed';
                       myButtons = {
                           Cancel: function() {
                               \$( this ).dialog( "close" );
                               return false;
                           }
                       }
                       addMessage="You can only schedule jobs after "+showDate[0]+". Please contact the production coordinator to schedule this press run.";
                   }
                   var a = this;
                   var \$dialog = \$('<div id="jConfirm"></div>')
                           .html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'+addMessage+'</p>')
                           .dialog({
                               autoOpen: false,
                               title: addTitle,
                               modal: true,
                               draggable: false,
                               buttons: myButtons,
                               open: function() {
                                   \$('.ui-dialog-buttonpane > button:last').focus();
                               }

                           });
                   \$dialog.dialog("open");
               } else {
                   noPerms('add');
               }
           }
     */
}
