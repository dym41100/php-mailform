// just for the demos, avoids form submit
jQuery.validator.setDefaults({
    //debug: true,
    success: "valid"
  });

// 郵便番号のルールを追加
jQuery.validator.addMethod("isZip", function(value, element) {
  return this.optional( element ) || /^\d{3}-?\d{4}$/.test( value );
}, '郵便番号を半角数字で正しく入力してください');

// 電話番号のルールを追加
jQuery.validator.addMethod("isTel", function(value, element) {
    return this.optional( element ) ||  /\d{2,4}-?\d{2,4}-?\d{4}/.test( value );
  }, '電話番号を半角数字で正しく入力してください');

$("#contact-form").validate({
    rules: {
        name: { required: true },
        email: { required: true, email: true },
        zip: { isZip: true },
        tel: { isTel: true },
        inquiry: { required: true }
    },
    messages: {
        name: "お名前を入力してください",
        email: {
            required: "メールアドレスを入力してください",
            email: "正しいメールアドレスを入力してください"
        },
        inquiry: "お問い合わせ内容を入力してください"
    },
    errorElement: "span",
    errorClass: "validation-error",
    errorPlacement: function (error, element) {
        error.appendTo(element.data("error_place"));
    }
});
