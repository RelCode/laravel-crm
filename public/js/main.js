var navHeight = document.getElementsByTagName('nav')[0].clientHeight;
console.log(document.getElementsByTagName('nav')[0].clientHeight)
var sideWidth = document.getElementsByClassName('sidebar')[0].clientWidth;
// document.querySelector('#crm-content-container').style.width = 'calc(100% - '+sideWidth+'px)';

// var mainContainer = document.querySelector('#crm-content-container');
var container = document.querySelector('#crm-content-container').children[0].clientHeight;
document.querySelector('#main-row').style.height = 'calc(100% - '+container+'px)';
// alert(document.getElementsByTagName('body')[0].offsetHeight);

$(document).on('click','.delete-lead',function(event){
    event.preventDefault()
    var item = event.currentTarget.parentElement.parentElement.childNodes[1].innerText;
    var action = 'delete';
    var token = event.currentTarget.previousElementSibling.value;//csrf token
    var id = event.currentTarget.dataset.user;
    new Swal({
        title: action + ' ' + item,
        text: 'are you sure?',
        icon: 'info',
        showConfirmButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: 'red',
        showCancelButton: true,
        cancelButtonText: 'No',
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = './leads/delete/?userId='+id+'&_token='+token;
        }
    });
})

$('#pickdatetime').datetimepicker({
    minDate: moment(),
    allowInputToggle: true,
    showClose: true,
    showClear: true,
    showTodayButton: true,
    format: "MM/DD/YYYY hh:mm:ss A",
    icons: {
        time:'fa fa-clock',

        date:'fa fa-calendar',

        up:'fa fa-chevron-up',

        down:'fa fa-chevron-down',

        previous:'fa fa-chevron-left',

        next:'fa fa-chevron-right',

        today:'fa fa-chevron-up',

        clear:'fa fa-trash',

        close:'fa fa-times'
        },

});