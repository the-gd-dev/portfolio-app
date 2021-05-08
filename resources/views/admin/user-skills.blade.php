<!-- Logout Modal-->
<div class="modal fade" id="UserSkillsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <form action="{{ route('admin.user-skills.store') }}" method="POST" id="userSkillsForm">
                
                <div class="modal-header border-0">
                    <h6 class="modal-title text-uppercase" id="exampleModalLabel">
                        <strong> 
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                            Add Additional Details Of your skills
                        </strong><br>
                        <small class="text-normal">
                            Add each skill's accuracy, summery. <br>
                            Move each skill using move icon on the very left.
                        </small>
                        <div class="reorder-message">lorem ipsum dolor sit amet.</div>
                    </h6>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    @csrf
                    <div class="form-group px-2 ">
                        <div class="row justify-content-between">
                            <div class="col-sm-3"><label>Skills </label></div>
                        </div>

                        <div class="border px-2 py-2 skills-loader-1" style="display: none;">
                            <div class="spinner-border text-dark spinner-border-sm" role="status"
                                style="top:-3px;position:relative;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            loading skills please wait ...
                        </div>
                        <select id="skills" multiple="multiple" value="" class="form-control">
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <div class="skills-loader-2 border text-dark p-4" style="display: none;">
                            <div class="spinner-border spinner-border-sm" style="top:-3px;position:relative;"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            loading skills details please wait ...
                        </div>
                        <div class="skills-list">
                            <table class="table table-sm">
                                <thead>
                                    <th></th>
                                    <th>Skill</th>
                                    <th>Accuracy (out of 100)%</th>
                                    <th>Summery</th>
                                </thead>
                                <tbody id="skills-table"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btn-sm"
                        onclick="$('#userSkillsForm').ajaxForm(responseHandle);">
                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

