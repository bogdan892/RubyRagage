$(document).ready(function () {
});


function saveProject(a) {
    var id = $(a).parents('.todo').attr('id');
    var item = $(a).siblings('input[type="text"]');
    var text=  $(a).siblings('.text');
    var button = $(a);
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "editProjectId=" + id + "&editProject=" + item.val(),
        success: function(data){
            text.text(item.val());
            item.hide();
            button.hide();
            text.show();
        }
    });
}

function editProject(a) {
    var id = $(a).parents('.todo').attr('id');
    var text = $(a).parents('.todo').find('.todo__title .text');
    var input = $(a).parents('.todo').find('.todo__title input[type="text"]');
    var button = $(a).parents('.todo').find('.todo__title input[type="button"]');
    text.toggle();
    input.toggle();
    button.toggle();
}
function TaskUp(a) {
    var id = $(a).parents('.todo__item').attr('id');
    var element = $(a).parents('.todo__item').prev().attr('id');
    console.log(id);
    console.log(element);
    if (element !== undefined){
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "TaskUp=" + id + "&Uppertask=" + element,
        success: function(data){
                var todo = $(data).find('.container').html();
                $('.container').html(data);
                OnLoad();

        }
    });
        }
}

function TaskDown(a) {
    var id = $(a).parents('.todo__item').attr('id');
    var element = $(a).parents('.todo__item').next().attr('id');
    console.log(id);
    console.log(element);
    if (element !== undefined){
        $.ajax({
        type: 'POST',
        url: "action.php",
        data: "DownUp=" + id + "&Downtask=" + element,
        success: function(data){
                var todo = $(data).find('.container').html();
                $('.container').html(data);
                OnLoad();
        }
    });
    }
}


function deleteProject(a) {
    var id = $(a).parents('.todo').attr('id');
    console.log(id);
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "deleteProject=" + id ,
        success: function(data){
            var todo = $(data).find('.container').html();
            $('.container').html(data);
            OnLoad();
        }
    });
}
function deleteItems(a) {
    var id = $(a).parents('.todo__item').attr('id');
    console.log(id);
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "deleteTask=" + id ,
        success: function(data){
            var todo = $(data).find('.container').html();
            $('.container').html(data);
            OnLoad();
        }
    });
}
function editTask(t){
    var dateInput = $(t).parents('.todo__item').find('.todo__text input[type="text"]');
    var text =  $(t).parents('.todo__item').find('.todo__text .text');
    var date=  $(t).parents('.todo__item').find('.todo__content .text');
    var item = $(t).parents('.todo__item').find('.todo__content input[type="text"]');
    var button = $(t).parents('.todo__item').find('.todo__content input[type="button"]');
    dateInput.toggle();
    text.toggle();
    date.toggle();
    item.toggle();
    button.toggle();
    console.log(text);
    console.log(item);
    var aa =false;
    item.focusout(function(){
        //alert(item.val());
        //item.hide();
    })
}
function slide() {
    $('#addProject').slideToggle();
}

function saveTask(t) {
    var task = $(t).parents('.todo__item').find('.todo__text input[type="text"]');
    var text=  $(t).parents('.todo__item').find('.todo__text .text');
    var id =  $(t).parents('.todo__item').attr('id');
    var button = $(t).parents('.todo__item').find('.todo__content input[type="button"]');
    var dateText = $(t).parents('.todo__item').find('.todo__content .text');
    var dateInput = $(t).parents('.todo__item').find('.todo__content input[type="text"]');
    text.text(task.val());
    dateText.text(dateInput.val());
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "editTaskId=" + id + "&editTask=" + task.val() + "&dateTask=" + dateInput.val(),
        success: function(data){
            task.hide();
            button.hide();
            dateInput.hide();
            text.show();
            dateText.show();
        }
    });
}
function chageStatus(t) {
    var content=  $(t).parents('.todo__item').find('.todo__content');
    var id = $(t).parents('.todo__item').attr('id');
    if ($(t).is(':checked')) {
        $.ajax({
            type: 'POST',
            url: "action.php",
            data: "statusYes=" + id ,
            success: function(data){
                $(content).addClass('checked');
            }
        });
        }
    else {
        $.ajax({
            type: 'POST',
            url: "action.php",
            data: "statusNo=" + id ,
            success: function(data){
                $(content).removeClass('checked');
            }
        });
    }
    }

function addTask(t) {
    var value = $(t).find("input[name='create']").val();
    var date = $(t).find("input[name='date']").val();
    var id = $(t).find("input[name='projectId']").val();
  //  var projectId  = 0;
    console.log(id);
    console.log(value);
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "createTask=" + value + "&ProjectID=" + id + "&ProjectDate=" + date ,
        success: function(data){
            var todo = $(data).find('.container').html();
            $('.container').html(data);
            OnLoad();
        }
    });
    return false;
}

function addProject(t) {
    var value = $(t).find("input[name='create']").val();
    $.ajax({
        type: 'POST',
        url: "action.php",
        data: "createProject=" + value ,
        success: function(data){
            var todo = $(data).find('.container').html();
            $('.container').html(data);
            OnLoad();
        }
    });
    console.log(value);
 return false;
}

function OnLoad(){
    $('.todo__item').mouseleave(function () {
        $('.todo__hidden', this).toggleClass('visible');
    });
    $('.todo__item').mouseenter(function () {
        $('.todo__hidden', this).toggleClass('visible');
    });
}

$(function () {
    $('.todo__new .date').datepicker();
    $(".datepicker").each(function() {
       $(this).datepicker();
    });
    OnLoad();
});