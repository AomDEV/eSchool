$('input:checkbox').removeAttr('checked');
function drawLabelSeat(seat_name,price,color){
    return '<div class="ui segment secondary '+color+'" align="left"><b><i class="icon cube"></i> '+seat_name+'</b> <div class="pull-right"><b>'+price+'</b><sup>THB</sup></div></div>';
}
$("input[type=checkbox]").click(function(e){
    var seat_name = $(this).data("seat");
    var seat_price = parseInt($(this).data("price"));
    var seat_color = $(this).data("color");
    var seat_prefix = seat_name[0];
    var seat_subfix = parseInt(seat_name.substring(1));
    if(seats.length <= 4 || $.inArray(seat_name,seats)!== -1){

        if($(this).is(':checked')){
            total += seat_price;
            seats.push(seat_name);
            $("div.seats-selected").html($("div.seats-selected").html() + drawLabelSeat(seat_name,seat_price,seat_color));
        } else{
            total -= seat_price;
            seats.splice($.inArray(seat_name, seats),1);
            $("div.seats-selected").html("");
            $.each(seats, function( index, value ) {
                $("div.seats-selected").html($("div.seats-selected").html() + drawLabelSeat(value,seat_price,$("#"+value).data("color")));
            });
        }
        $("span.total-price").html(total);
    } else{
        alert("Maximum seating capacity is 5 seats.");
        event.preventDefault();
        event.stopPropagation();
    }
    var btnPointer = "button.ui.button.checkout";
    if(seats.length>0){$(btnPointer).prop('disabled', false);} else{$(btnPointer).prop('disabled', true);}

});
$("button.ui.button.checkout").click(function(){

    var passed = true;
    if(seats.length>0){
        var head_seat = [];
        for(var i=0;i<seats.length;i++){
            head_seat.push(seats[i][0]);
        }
        head_seat = (jQuery.unique(head_seat));
        for(var j=0;j<head_seat.length;j++){
            var skiped = 0;
            var head=[];
            for(var k=0;k<seats.length;k++){
                if(seats[k][0]==head_seat[j]){head.push(seats[k]);}
            }
            for(var i=parseInt(head.sort()[0].substring(1));i<=head.sort()[(head.length-1)].substring(1);i++){
                var seat_name = head_seat[j]+i;
                if($.inArray(seat_name,seats)!==-1){
                    console.log("Found "+seat_name);
                    if(skiped==1){
                        passed = false;
                        alert("Leave seat more than 1 seat");
                    }
                    skiped=0;
                } else{console.log("Not found "+seat_name);skiped++;}
            }
        }
    }

    if(passed){
        $("input[name=time]").val(time_id);
        $.each($("input[name='seat[]']").map(function(){return $(this);}).get(),function(index,value){
            value.remove();
        });

        for(var i=0;i<seats.length;i++){
            console.log(seats[i]);
            $(".next-step").append("<input type=hidden name=seat[] value="+seats[i]+" />");
        }
        $(".next-step").submit();
    }
});