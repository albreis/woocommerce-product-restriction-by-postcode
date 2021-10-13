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
//# sourceMappingURL=app.js.map