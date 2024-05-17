
<!-- upload image -->
<div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="modalImageLabel" aria-hidden="true">
  <form method="POST" id="form-image" action="{{url('upload')}}">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalImageLabel">Upload Image</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div id="dropFileState" ondragover="return false">
                    <div id="dragUploadFile">
                        <p>File Type：PNG，JPG，GIF，TIFF<br/>
                         File Size：5MB
                       </p>
                        <input type="file" id="photo" name="photo" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="jpg png gif tiff jpeg"  />
                    </div>
                </div>
                <div class="text-center mt-2">
                  <button type="button" class="btn btn-success mb-3" id="btnUploadImage"><i class="fa fa-excel"></i> Upload</button>
                </div>
              </div>
          </div>
      </div>
  </form>
</div>