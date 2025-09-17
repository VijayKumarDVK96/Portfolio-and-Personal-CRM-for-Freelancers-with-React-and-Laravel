<script>
    function changeCity(id='') {
        var state = $('#state').val();
        $.ajax({
            url: base_url+"/show-cities/"+state,
            method: 'post',
            success: function(data) {
                $('#city').html(data);
                if(id != '') {
                    $('#city').val(id);
                }
            }
        });
    }
    
    function imageUpload(crop_layout, input_file, modal, width, height, url, upload_button, type) {
        window.addEventListener('DOMContentLoaded', function () {
            var image = document.getElementById(crop_layout);
            var input = document.getElementById(input_file);
            var $modal = $(modal);
            var cropper;

            input.addEventListener('change', function (e) {
                var files = e.target.files;
                var done = function (url) {
                    input.value = '';
                    image.src = url;
                    $modal.modal('show');
                };

                $($modal).modal({
                    backdrop: 'static',
                    keyboard: false
                });

                var reader;
                var file;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function () {
                if(type != 'profile_image') {
                    cropper = new Cropper(image, {
                        autoCropArea: 3,
                    });
                } else {
                    cropper = new Cropper(image, {
                        aspectRatio: 1
                    });
                }
                
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            document.getElementById(upload_button).addEventListener('click', function () {
                $('#'+upload_button).attr('disabled', true);
                $('#'+upload_button+' .spinner-border').css('display', 'inline-block');

                var canvas;

                $modal.modal('hide');

                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: width,
                        height: height,
                    });
                    
                    canvas.toBlob(function (blob) {
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function () {
                            var base64data = reader.result;
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: url,
                                data: {
                                    'image': base64data
                                },
                                success: function (data) {
                                    img = base_url+'/'+data.image;
                                    if(type == 'portfolio') {
                                        $(".no-portfolio-image").parent().parent().remove();
                                        $(".portfolio").prepend('<div class="col-sm-6 col-md-4 edit-gallery-block"><div class="thumb"><img src="'+img+'" alt="" width="100%"><label class="icon-delete btn-danger" onclick="deletePortfolioImage('+data.id+', this)"><i class="fa fa-trash"></i></label></div></div>');
                                    } else if(type == 'thumbnail') {
                                        $(".thumbnail-image img").attr('src', img);
                                    } else if(type == 'profile_image') {
                                        $(".profile-image img").attr('src', img);
                                    } else if(type == 'add_certification') {
                                        $("#add_image").val(data.image);
                                        $("#image_type").val(type);
                                        $('#add_certification_preview').attr('src', img);
                                    } else if(type == 'edit_certification') {
                                        $("#edit_image").val(data.image);
                                        $("#image_type").val(type);
                                        $('#edit_certification_preview').attr('src', img);
                                    }

                                    $modal.modal('hide');
                                },
                                complete: function() {
                                    $('#'+upload_button).attr('disabled', false);
                                    $('#'+upload_button+' .spinner-border').css('display', 'none');
                                }
                            });
                        }
                    });
                }
            });
        });
    }
</script>