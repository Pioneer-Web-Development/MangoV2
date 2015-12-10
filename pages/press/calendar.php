<?php
$template = 'master';

include($_SERVER['DOCUMENT_ROOT']."/includes/bootstrap.php");

function page()
{
    page_title("Press Calendar");
    print "<div id='calendar'></div>";
$calendarScript = <<<CALSCRIPT

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
            type: 'POST'
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
            ajaxCall('/calendar/'+event.id+'/move',data,null,revertFunc);
            /*
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
           */
       },
       eventResize: function(event, delta, revertFunc) {
           tooltip.hide();
           var data =  {hours:delta.hours(),minutes:delta.minutes()};
           ajaxCall('/calendar/'+event.id+'/resize',data,null,revertFunc);
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
           tooltip.hide();
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
           tooltip.hide();
           \$(this).css('border-color',event.color);
       },

       dayClick: function(date, allDay, jsEvent, view) {
           tooltip.hide();
           /*
            if (allDay) {
            alert('Clicked on the entire day: ' + date);
            }else{
            alert('Clicked on the slot: ' + date);
            }

            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            alert('Current view: ' + view.name);
            */
           // change the day's background color just for fun
           /*
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
       },

       eventRender: function(event, element) {
           element.data('id',event.id);
           element.bind('dblclick', function() {
               loadJob(event.id);
           });
           element.contextMenu({
               menuSelector: "#pressCalendarContextMenu",
               menuSelected: function (invokedOn, selectedMenu, event) {
                   console.log(element);
                   handlePressContextMenu(invokedOn,selectedMenu, event);
               }
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
                       showMessage(message);
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


    function loadJob(id)
    {
        \$('#jobID').html(id);
        \$('#jobEditor').modal({
        });
        \$('#presswizard').bootstrapWizard({
            onShow: function (tab, navigation, index)
            {
                \$('#presswizard').bootstrapWizard('show',0);
            },
            onTabShow: function(tab, navigation, index) {
                var \$total = navigation.find('li').length;
                var \$current = index+1;
                var \$percent = (\$current/\$total) * 100;
                \$('#presswizard').find('.bar').css({width:\$percent+'%'});

                // If it's the last tab then hide the last button and show the finish instead
                if(\$current >= \$total) {
                    \$('#presswizard').find('.pager .next').hide();
                    \$('#presswizard').find('.pager .finish').show();
                    \$('#presswizard').find('.pager .finish').removeClass('disabled');
                } else {
                    \$('#presswizard').find('.pager .next').show();
                    \$('#presswizard').find('.pager .finish').hide();
                }

            },
            onTabChange:function (tab,navigation,index)
            {
                console.log('Would be saving now...');
                console.log(tab);
                console.log("Index is "+index);
            },
            onFinish: function ()
            {
                console.log('theoretically we are now finished');
            }
        });
    }
    function handlePressContextMenu(invokedOn,selectedMenu, event)
    {
        console.log("Event ID: "+event.id);
        console.log("Selected Action: "+selectedMenu.data('action'));
    }

CALSCRIPT;
    $GLOBALS['scripts'][]=$calendarScript;
}
