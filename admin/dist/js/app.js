window.addEventListener('load', function () {
    document.querySelectorAll('.cep input').forEach(function (item) {
        item.addEventListener('keyup', function (e) {
            if (e.target.value.length > 5) {
                e.target.value = e.target.value.replace(/([\d]{5})-?([\d]{3})?/gi, '$1-$2');
            }
        });
    });
});
//# sourceMappingURL=app.js.map