var SpinSubmit = function(submit) {
  this.submit = submit;
  this.originalText = this.submit.text();

  this.submit.html('<span class="original">' + this.originalText + '</span>');

  this.original = this.submit.children('.original');

  //this.submit.prepend('<span class="spinner">⟲</span>');
  this.submit.prepend('<span class="spinner"></span>');
}

SpinSubmit.prototype.start = function (text) {
  this.original.text((text ? text : this.originalText));
  this.submit.addClass('submit-spinner--spinning');
}

SpinSubmit.prototype.stop = function (text) {
  this.original.text((text ? text : this.originalText));
  this.submit.removeClass('submit-spinner--spinning');
}
