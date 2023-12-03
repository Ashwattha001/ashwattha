"use strict";
var ScheduleList = [];
var SCHEDULE_CATEGORY = ["milestone", "task"];

function ScheduleInfo() {
    this.id = null;
    this.calendarId = null;
    this.title = null;
    this.body = null;
    this.isAllday = false;
    this.start = null;
    this.end = null;
    this.category = "";
    this.dueDateClass = "";
    this.color = null;
    this.bgColor = null;
    this.dragBgColor = null;
    this.borderColor = null;
    this.customStyle = "";
    this.isFocused = false;
    this.isPending = false;
    this.isVisible = true;
    this.isReadOnly = false;
    this.goingDuration = 0;
    this.comingDuration = 0;
    this.recurrenceRule = "";
    // this.state = "";
    // this.raw = {
    //   memo: "",
    //   hasToOrCc: false,
    //   hasRecurrenceRule: false,
    //   location: null,
    //   class: "public",
    //   creator: {
    //     name: "",
    //     avatar: "",
    //     company: "",
    //     email: "",
    //     phone: "",
    //   },
    // };
}

function generateTime(e, startDate, endDate) {
    //  const startDate1 = new Date(startDate);
    // const endDate1 = new Date(endDate);
    // console.log(e);
    e.category = "time";
    e.start = startDate;
    e.end = endDate;
}

function generateNames() {
    var e = [];
    for (
        var a = 0,
        o = chance.integer({
            min: 1,
            max: 10,
        });
        a < o;
        a += 1
    )
        e.push(chance.name());
    return e;
}

function generateRandomSchedule(e, a, o) {
    // API HIT
    // try{
    //     const response = await $.get(
    //         getScheduleUrls
    //     );
    //     console.log(response)
    // }
    // catch (err){
    //     console.log(err);
    // }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: getScheduleUrls,
        type: 'get',
        data: {},
        cache: false,
        dataType: 'json',
        success: function (data) {

            // console.log(data);
            var n;
           
            // // console.log(e.id, e.name, a._date, o._date);
            var  il = 0;
            $.each(data.data, function (index, row) {
                var i = new ScheduleInfo();
                const id = row.id;
                const title = row.title;
                // const startDate = row.start;
                // const endDate = row.end;

                i.id = id;
                i.calendarId = "1";
                i.title = title;
                i.body = "row.body";
                const startDate = new Date("09/12/2023");
                const endDate = new Date("09/14/2023");
                generateTime(i, startDate, endDate);

                i.color = "#556ee6";
                i.bgColor = "#556ee6";
                i.dragBgColor = "#556ee6";
                i.borderColor = "#556ee6";
            
                ScheduleList.push(i);
                // console.log(i);
                // console.log(ScheduleList);
            });

        }
    });
}

// function generateRandomSchedule(e, a, o) {
//     // console.log(e.id, e.name, a._date, o._date);
//     // API HIT
//     var n;
//     var i = new ScheduleInfo();
//     i.id = chance.guid();
//     i.calendarId = e.id;
//     i.title = "hello";
//     i.body = chance.bool({
//         likelihood: 20,
//     })
//         ? chance.sentence({
//             words: 10,
//         })
//         : "";

//     const startDate = new Date("09/12/2023");
//     const endDate = new Date("09/14/2023");
//     generateTime(i, startDate, endDate);

//     i.color = e.color;
//     i.bgColor = e.bgColor;
//     i.dragBgColor = e.dragBgColor;
//     i.borderColor = e.borderColor;
//     "milestone" === i.category &&
//         ((i.color = i.bgColor),
//             (i.bgColor = "transparent"),
//             (i.dragBgColor = "transparent"),
//             (i.borderColor = "transparent"));

//     // console.log(i);
//     ScheduleList.push(i);
// // console.log(ScheduleList);

// }

// async function generateRandomSchedule(e, a, o) {
//     // API HIT
//     // try{
//     //     const response = await $.get(
//     //         getScheduleUrls
//     //     );
//     //     console.log(response)
//     // }
//     // catch (err){
//     //     console.log(err);
//     // }
//     // $.ajax({
//     //     headers: {
//     //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     //     },
//     //     url: getScheduleUrls,
//     //     type: 'get',
//     //     data: {},
//     //     cache: false,
//     //     dataType: 'json',
//     //     success: function (data) {

//     //         var n;
//     //             var i = new ScheduleInfo();
//     //             i.id = chance.guid();
//     //             i.calendarId =e.id;
//     //             i.title = "hello";
//     //             i.body = chance.bool({
//     //                 likelihood: 20,
//     //             })
//     //                 ? chance.sentence({
//     //                     words: 10,
//     //                 })
//     //                 : "";
//     //             // i.isReadOnly = chance.bool({
//     //             //   likelihood: 20,
//     //             // });
            
//     //             const startDate = new Date("09/12/2023");
//     //             const endDate = new Date("09/14/2023");
//     //             generateTime(i, startDate, endDate);
//     //             // i.isPrivate = chance.bool({
//     //             //   likelihood: 10,
//     //             // });
//     //             // i.location = chance.address();
//     //             // i.attendees = chance.bool({
//     //             //   likelihood: 70,
//     //             // })
//     //             //   ? generateNames()
//     //             //   : [];
//     //             // i.recurrenceRule = chance.bool({
//     //             //   likelihood: 20,
//     //             // })
//     //             //   ? "repeated events"
//     //             //   : "";
//     //             // i.state = chance.bool({
//     //             //   likelihood: 20,
//     //             // })
//     //             //   ? "Free"
//     //             //   : "Busy";
//     //             i.color = e.color;
//     //             i.bgColor = e.bgColor;
//     //             i.dragBgColor = e.dragBgColor;
//     //             i.borderColor = e.borderColor;
//     //             "milestone" === i.category &&
//     //                 ((i.color = i.bgColor),
//     //                     (i.bgColor = "transparent"),
//     //                     (i.dragBgColor = "transparent"),
//     //                     (i.borderColor = "transparent"));
//     //             // i.raw.memo = chance.sentence();
//     //             // i.raw.creator.name = chance.name();
//     //             // i.raw.creator.avatar = chance.avatar();
//     //             // i.raw.creator.company = chance.company();
//     //             // i.raw.creator.email = chance.email();
//     //             // i.raw.creator.phone = chance.phone();
//     //             // chance.bool({
//     //             //   likelihood: 20,
//     //             // }) && ((n = chance.minute()), (i.goingDuration = n), (i.comingDuration = n));
//     //             console.log(i);
//     //             ScheduleList.push(i);
//     //         // console.log(ScheduleList);


//     //         // // // console.log(data);
//     //         // // var n;
           
//     //         // // // console.log(e.id, e.name, a._date, o._date);
//     //         // var  il = 0;
//     //         // $.each(data.data, function (index, row) {
//     //         //     var i = new ScheduleInfo();
//     //         //     const id = row.id;
//     //         //     const title = row.title;
//     //         //     // const startDate = row.start;
//     //         //     // const endDate = row.end;

//     //         //     i.id = id;
//     //         //     i.calendarId = calendarId;
//     //         //     i.title = title;
//     //         //     i.body = "row.body";
//     //         //     const startDate = new Date("09/12/2023");
//     //         //     const endDate = new Date("09/14/2023");
//     //         //     generateTime(i, startDate, endDate);

//     //         //     i.color = "#556ee6";
//     //         //     i.bgColor = "#556ee6";
//     //         //     i.dragBgColor = "#556ee6";
//     //         //     i.borderColor = "#556ee6";
//     //         //     // "milestone" === "milestone" &&
//     //         //     //     ((i.color = i.bgColor),
//     //         //     //         (i.bgColor = "transparent"),
//     //         //     //         (i.dragBgColor = "transparent"),
//     //         //     //         (i.borderColor = "transparent"));
            
//     //         //     ScheduleList.push(i);
//     //         //     // console.log(i);
//     //         //     console.log(ScheduleList);

//     //         // });
            
//     //     }
//     // });


//     // i.isReadOnly = chance.bool({
//     //   likelihood: 20,
//     // });


//     // i.isPrivate = chance.bool({
//     //   likelihood: 10,
//     // });
//     // i.location = chance.address();
//     // i.attendees = chance.bool({
//     //   likelihood: 70,
//     // })
//     //   ? generateNames()
//     //   : [];
//     // i.recurrenceRule = chance.bool({
//     //   likelihood: 20,
//     // })
//     //   ? "repeated events"
//     //   : "";
//     // i.state = chance.bool({
//     //   likelihood: 20,
//     // })
//     //   ? "Free"
//     //   : "Busy";

//     // i.raw.memo = chance.sentence();
//     // i.raw.creator.name = chance.name();
//     // i.raw.creator.avatar = chance.avatar();
//     // i.raw.creator.company = chance.company();
//     // i.raw.creator.email = chance.email();
//     // i.raw.creator.phone = chance.phone();
//     // chance.bool({
//     //   likelihood: 20,
//     // }) && ((n = chance.minute()), (i.goingDuration = n), (i.comingDuration = n));

// }

function generateSchedule(n, i, t) {
    ScheduleList = [];
    console.log(ScheduleList);
    CalendarList.forEach(function (e) {
        var a = 0;
        var o = 10;
        for ("month" === n ? (o = 1) : "day" === n && (o = 4); a < o; a += 1)
            generateRandomSchedule(e, i, t);
    });
}
