let clickCordinate = [];
$(document).click(function (e) {
    clickCordinate = [e.pageX, e.pageY];
});

// Use the createScheduleUrl variable defined in the Blade template
// const getScheduleUrls = getScheduleUrls;
const calendarList = [
    {
        id: "1",
        title: "This is test schedule",
        category: "time",
        start: "2023-09-01T09:00:00",
        end: "2023-09-02T10:00:00",
    },
    {
        id: "2",
        title: "This is test schedule",
        category: "time",
        start: "2023-09-03T09:00:00",
        end: "2023-09-04T10:00:00",
    },
    {
        id: "3",
        title: "This is test schedule",
        category: "time",
        start: "2023-09-03T09:00:00",
        end: "2023-09-06T10:00:00",
    },

   

];

function records(){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url:getScheduleUrls,
        type :'get',
        data : {},
        cache: false,
        dataType: 'json',                 
        success:function(data){
            console.log(data);
           
            $.each(data.data,function(index,row){
                const ids = row.id;
                const title = row.title;
                const start = row.start;
                const end = row.end;
                
                const schedule = {
                    id: String(ids),
                    title,
                    category: "time",
                    start,
                    end,
                };

                calendar.createSchedules([schedule]);
               
            });
        }
    })
}

function renderRange(calendar) {
    const start = calendar.getDateRangeStart();
    const end = calendar.getDateRangeEnd();
    let dateFormate = new Date(start._date);
    //   add 1 month
    dateFormate.setMonth(dateFormate.getMonth() + 1);

    document.querySelector("#renderRange").innerHTML =
        dateFormate.toLocaleString("default", { month: "long" }) +
        " " +
        dateFormate.getFullYear();
}

const calendar = new tui.Calendar("#calendar", {
    defaultView: "month",
    selectable: true,
});
// remove multi select
// calendar.setOptions({
//   selectable: false,
//   month: {
//     daynames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
//     startDayOfWeek: 0,
//     narrowWeekend: true,
//   },
// });

// calendar.createSchedules(calendarList);
renderRange(calendar);
records();

function showPopup() {
    let perform = $(".performHere");
    console.log(clickCordinate);
    perform.removeClass("d-none");
    perform.css({
        position: "absolute",
        zIndex: 9999,
        top: clickCordinate[1] + 100,
        left: clickCordinate[0] - 200,
    });
}

// on drag or chnage schedule
calendar.on("beforeUpdateSchedule", (e) => {
    const { schedule, changes } = e;
    const { start, end } = changes;
    const { id, calendarId } = schedule;
    const newSchedule = {
        id,
        start,
        end,
    };

    console.log(id, start, end);

        // // Use the createScheduleUrl variable defined in the Blade template
        const url = createScheduleUrl;
        // // api call
        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            type :'post',
            data : {title:title,start:start,end:end},
            async: false,
            cache: true,
            dataType: 'json',
            success:function(response){
                console.log(response);
    
                if (response.status==true) {  
    
                    const ids = response.ids;
                    const title = response.title;
                    const start = response.start;
                    const end = response.end;
                    
                    const schedule = {
                        id: String(ids),
                        title,
                        category: "time",
                        start,
                        end,
                    };
                    calendar.createSchedules([schedule]);
                    form.reset();
    
                    //For Notification
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.showEasing= 'swing';
                    toastr.options.hideEasing= 'linear';
                    toastr.options.showMethod= 'fadeIn';
                    toastr.options.hideMethod= 'fadeOut';
                    toastr.options.closeButton= true;
                    toastr.success(response.message);
        
                }else{
    
                    //For Notification
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.showEasing= 'swing';
                    toastr.options.hideEasing= 'linear';
                    toastr.options.showMethod= 'fadeIn';
                    toastr.options.hideMethod= 'fadeOut';
                    toastr.options.closeButton= true;
                    toastr.error(response.message);
                }
            }
        });
    calendar.updateSchedule(id, calendarId, newSchedule);
});

// on click schedule
calendar.on("clickSchedule", (e) => {
    const { calendar, schedule } = e;
    const { id, calendarId } = schedule;
    console.log(schedule);

    //   calendar.deleteSchedule(id, calendarId);
});

// 1
//on form submit
const form = document.querySelector("#form2");
form.addEventListener("submit", (e) => {
    e.preventDefault();
    const ids = document.querySelector("#id2").value;
    const title = document.querySelector("#title2").value;
    const start = document.querySelector("#start2").value;
    const end = document.querySelector("#end2").value;
    // Use the createScheduleUrl variable defined in the Blade template
      const url = createScheduleUrl;
    // api call
    $.ajax({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url:url,
        type :'post',
        data : {title:title,start:start,end:end},
        async: false,
        cache: true,
        dataType: 'json',
        success:function(response){
            console.log(response);

            if (response.status==true) {  

                const ids = response.ids;
                const title = response.title;
                const start = response.start;
                const end = response.end;
                
                const schedule = {
                    id: String(ids),
                    title,
                    category: "time",
                    start,
                    end,
                };
                calendar.createSchedules([schedule]);
                form.reset();

                //For Notification
                toastr.options.timeOut = 5000;
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.showEasing= 'swing';
                toastr.options.hideEasing= 'linear';
                toastr.options.showMethod= 'fadeIn';
                toastr.options.hideMethod= 'fadeOut';
                toastr.options.closeButton= true;
                toastr.success(response.message);
    
            }else{

                //For Notification
                toastr.options.timeOut = 5000;
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.showEasing= 'swing';
                toastr.options.hideEasing= 'linear';
                toastr.options.showMethod= 'fadeIn';
                toastr.options.hideMethod= 'fadeOut';
                toastr.options.closeButton= true;
                toastr.error(response.message);
            }
        }
    });


 
});

// on slot change
calendar.on("beforeCreateSchedule", (e) => {
    const { start, end } = e;
    let startDate = new Date(start._date);
    startDate.setDate(startDate.getDate() + 1);
    document.querySelector("#start2").value = startDate
        .toISOString()
        .slice(0, 10);
    let endDate = new Date(end._date);
    document.querySelector("#end2").value = endDate.toISOString().slice(0, 10);
    showPopup();
});

//  handle click on data-action="move-prev" button
$('[data-action="move-prev"]').click(function () {
    calendar.prev();
    renderRange(calendar);
    //   render the calendar month and date in id = renderRange
});
$('[data-action="move-next"]').click(function () {
    calendar.next();
    renderRange(calendar);
});
// move-today button
$('[data-action="move-today"]').click(function () {
    calendar.today();
    renderRange(calendar);
});


// handle next month button
// const nextBtn = document.querySelector(".tui-full-calendar-btn-next");
// nextBtn.addEventListener("click", () => {
//     const start = calendar.getDateRangeStart();
//     const end = calendar.getDateRangeEnd();
//     console.log(start, end);
// });
// var calendar = new tui.Calendar("#calendar2", {
//   defaultView: "month",
//   useCreationPopup: true,
//   useDetailPopup: true,
//   taskView: true,
//   scheduleView: true,
//   template: {
//     task: function (schedule) {
//       return schedule.title;
//     },
//     milestone: function (schedule) {
//       return schedule.title;
//     },
//     allday: function (schedule) {
//       return schedule.title + " (All day)";
//     },
//   },
// });

// // Sample events (you can load your events dynamically)
// calendar.createSchedules([
//   {
//     id: "1",
//     calendarId: "1",
//     title: "Sample Event 1",
//     start: "2023-09-01T09:00:00",
//     end: "2023-09-01T10:00:00",
//     isAllDay: true,
//   },
//   {
//     id: "2",
//     calendarId: "2", // This event belongs to calendar ID 2
//     title: "Sample Event 2",
//     start: "2023-09-02T10:00:00",
//     end: "2023-09-02T12:00:00",
//     isAllDay: true,
//   },
//   // Add more events here
// ]);

// // Create a new calendar
// calendar.createCalendar({
//   id: "2",
//   name: "My New Calendar",
//   bgColor: "#FF5733",
//   borderColor: "#FF5733",
//   color: "#FFFFFF",
// });

// // Add events to the new calendar
// calendar.createSchedules([
//   {
//     id: "3",
//     calendarId: "2",
//     title: "Event in My New Calendar",
//     start: "2023-09-03T14:00:00",
//     end: "2023-09-03T16:00:00",
//     isAllDay: false,
//   },
//   // Add more events for the new calendar here
// ]);

// "use strict";
// var CalendarList = [];

// function CalendarInfo() {
//   (this.id = null),
//     (this.name = null),
//     (this.checked = !0),
//     (this.color = null),
//     (this.bgColor = null),
//     (this.borderColor = null),
//     (this.dragBgColor = null);
// }

// function addCalendar(r) {
//   CalendarList.push(r);
// }

// function findCalendar(a) {
//   var o;
//   return (
//     CalendarList.forEach(function (r) {
//       r.id === a && (o = r);
//     }),
//     o || CalendarList[0]
//   );
// }

// function hexToRGBA(r) {
//   return (
//     "rgba(" +
//     parseInt(r.slice(1, 3), 16) +
//     ", " +
//     parseInt(r.slice(3, 5), 16) +
//     ", " +
//     parseInt(r.slice(5, 7), 16) +
//     ", " +
//     (parseInt(r.slice(7, 9), 16) / 255 || 1) +
//     ")"
//   );
// }
// !(function () {
//   var r = new CalendarInfo();
//   (r.id = String(1)),
//     (r.name = "My Calendar"),
//     (r.color = "#ffffff"),
//     (r.bgColor = "red"),
//     (r.dragBgColor = "#556ee6"),
//     (r.borderColor = "#556ee6"),
//     addCalendar(r);
// })();
