var navHeight = document.getElementsByTagName('nav')[0].clientHeight;
var sideWidth = document.getElementsByClassName('sidebar')[0].clientWidth;
document.querySelector('#crm-content-container').style.height = 'calc(100% - '+navHeight+'px)';
// document.querySelector('#crm-content-container').style.width = 'calc(100% - '+sideWidth+'px)';

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