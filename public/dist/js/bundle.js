(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
var ProductRestrictionByPostcode = (function () {
    function ProductRestrictionByPostcode() {
        var _this = this;
        this.popup = document.querySelector('.product-restriction-by-postcode');
        this.input = this.popup.querySelector('input');
        this.button = this.popup.querySelector('button');
        var vue = document.createElement('script');
        vue.src = 'https://unpkg.com/vue';
        document.body.appendChild(vue);
        var axios = document.createElement('script');
        axios.src = 'https://unpkg.com/axios';
        document.body.appendChild(axios);
        if (document.querySelector('#popupcep')) {
            document.querySelector('#popupcep').addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                _this.popup.style.display = 'flex';
            });
        }
    }
    ProductRestrictionByPostcode.prototype.save_postcode = function (postcode) {
        var _this = this;
        axios.post(window.ajaxurl, { postcode: postcode }, { params: { action: 'save_postcode' } }).then(function (res) {
            console.log(res.data);
            _this.popup.style.display = 'none';
        });
    };
    return ProductRestrictionByPostcode;
}());
window.addEventListener('load', function () {
    var app = new ProductRestrictionByPostcode;
    app.input.addEventListener('keyup', function (e) {
        var postcode = app.input.value;
        if (postcode.length == 8) {
            app.button.style.display = 'block';
        }
    });
    app.button.addEventListener('click', function () {
        var postcode = app.input.value;
        app.save_postcode(postcode);
    });
});

},{}]},{},[1]);
