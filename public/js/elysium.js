$('#modalCourse').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget),
  	  cid = button.data('cid'),
	  cgid = button.data('cgid'),
	  title = button.data('title'),
  	  modal = $(this);
debugger
  modal.find('.modal-title').text('Kurs bearbeiten: ' + title);
  modal.find('.modal-body #course-cid').val(cid);
  modal.find('.modal-body #course-cgid').val(cgid);
  modal.find('.modal-body #course-title').val(title);
})
