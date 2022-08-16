var navHeight = document.getElementsByTagName('nav')[0].clientHeight;
var sideWidth = document.getElementsByClassName('sidebar')[0].clientWidth;
document.querySelector('#crm-content-container').style.height = 'calc(100% - '+navHeight+'px)';
// document.querySelector('#crm-content-container').style.width = 'calc(100% - '+sideWidth+'px)';