@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Porfolios Table Updated !!',
                        bg_color: '#62f764'
                    });
                    
                    if (response.data) {
                        setTimeout(() => {
                            window.location.replace(response.data.url);
                        }, 2000);
                    }
                 
                }
            }
        }

    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"> {{ isset($portfolio->id) ? 'Update' : 'New' }}
                            Portfolio</h6>
                        <div class="d-flex">
                            <a href="{{ route('admin.portfolios.index') }}"
                                class="btn btn-light border px-3 btn-sm arrow-btn"> <i class="fa fa-arrow-left"></i> Back to
                                Portfolios
                            </a>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data"
                            id="PortFolioForm">
                            <div class="row justify-content-between">
                                @csrf
                                <input type="hidden" name="portfolio_id" value="{{ $portfolio->id ?? '' }}">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label>Portfolio Images</label>
                                            @if (isset($portfolio->images))
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-light border" data-toggle="modal" data-target="#sortImages" ><i
                                                            class="fa fa-sort"  ></i> Set Images Order</button>
                                                    <button data-toggle="modal" data-target="#coverImageChange"
                                                        type="button" class="btn btn-sm btn-light border ml-2"><i
                                                            class="fa fa-image"></i> Set Portfolio Cover</button>
                                                </div>
                                            @endif
                                        </div>

                                        <label class="dropzone portfolio-images-wrapper">

                                            <div class="dz-preview row justify-content-center" id="portfolio_images">
                                                @if (isset($portfolio->images) && $portfolio->images->count() > 0)
                                                    @foreach ($portfolio->images as $image)
                                                        <div class="porfolio-image col-sm-4 mb-4">
                                                            <img
                                                                src="{{ asset('storage/portfolio-images/' . auth()->user()->id . '/' . $image->name) }}" />
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            @if (!isset($portfolio->images))
                                                <div class="dropzone-message lg">
                                                    Click Or Drop Your files Here
                                                </div>
                                            @endif
                                            <input type="file" data-loader="#banner-loader" name="about_image"
                                                class="direct-image-upload "
                                                data-action="{{ route('admin.portfolio.images') }}" data-multiple="true"
                                                data-max="10" data-image-view="#portfolio_images" style="display:none;"
                                                accept="image/*" multiple="multiple" data-hidden-field="portfolio_images"
                                                value="" />
                                        </label>
                                    </div>
                                    <p>
                                        Please <b>upload</b> or <b>drop</b> the images here. <br>
                                        You can't upload more then 10 files.<br>
                                        All files should be an image. <br>
                                        Recommended Size : <b>250px X 800px</b>
                                    </p>
                                    <input type="hidden" name="portfolio_images" value="">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" required autocomplete="" class="form-control" name="name"
                                            value="{{ $portfolio->name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="pcat_id" required class="form-control">
                                            @if ($portfolio_categories->count() > 0)
                                                @foreach ($portfolio_categories as $pcat)
                                                    <option @if (isset($portfolio->pcat_id) && $pcat->id == $portfolio->pcat_id) selected @endif value="{{ $pcat->id }}">
                                                        {{ $pcat->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input type="text" autocomplete="" class="form-control" name="client_name"
                                            value="{{ $portfolio->client_name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" max="{{ date('Y-m-d') }}" autocomplete="" class="form-control"
                                            name="project_date" value="{{ $portfolio->project_date ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea type="text" autocomplete="" class="form-control" id="description"
                                            name="description">{!! $portfolio->description ?? '' !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Link</label>
                                        <input type="url" autocomplete="" class="form-control" name="link"
                                            value="{{ $portfolio->link ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 justify-content-center text-center mt-4">
                                    <button class="btn btn-primary px-5"
                                        onclick="$('#PortFolioForm').ajaxForm(ResponseHandeling);">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        {{ isset($portfolio->id) ? 'Update' : 'Create' }} Portfolio
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($portfolio->images))
        <div class="modal fade mt-5" id="coverImageChange" role="dialog" aria-labelledby="coverImageChangeLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="coverImageChangeLabel">Update Cover Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row portfolio_cover_images" id="portfolio_cover_images">
                            @if (isset($portfolio->images) && $portfolio->images->count() > 0)
                                @foreach ($portfolio->images as $image)
                                    <div data-id="{{ $image->id }}"
                                        class="porfolio-image-cover col-md-4 mb-4 {{ $portfolio->portfolio_cover == $image->id ? 'active' : '' }}">
                                        <img
                                            src="{{ asset('storage/portfolio-images/' . auth()->user()->id . '/' . $image->name) }}" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade mt-5" id="sortImages" role="dialog" aria-labelledby="sortImagesLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sortImagesLabel">Re Order Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <ul class="row sort_images list-unstyled" id="sort_images">
                            @if (isset($portfolio->images) && $portfolio->images->count() > 0)
                                @foreach ($portfolio->images as $image)
                                    <li class="porfolio-sort-image col-md-3 mb-4" data-id="{{ $image->id }}">
                                        <img
                                            height="50"
                                            src="{{ asset('storage/portfolio-images/' . auth()->user()->id . '/' . $image->name) }}" />
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@section('scripts')
    <script>
        @if (isset($portfolio->images))
            async function updatePortfolio(data){
                const updateUrl = "{{ route('admin.portfolios.update', $portfolio->id) }}";
                return await $.post(updateUrl, {_method:'PATCH', ...data});
            }
            $(document).on('click', '.porfolio-image-cover' , async function(){
                const portfolio_cover = $(this).data('id');
                $('.porfolio-image-cover').removeClass('active');
                $(this).addClass('active');
                const response = await updatePortfolio({portfolio_cover});
                if (response.status) {
                    toasterMsg({
                        heading: 'Success',
                        text: 'Porfolios Cover Updated !!',
                        bg_color: '#62f764'
                    });
                    $('#coverImageChange').modal('hide');
                }
        
            })
        @endif
        $(document).ready(function() {
            CKEDITOR.replace('description', {
                height: '120',
            });
        })
        //initialization of sorting
        $(function () {
            $("#sort_images").sortable({
                update: async function (event, ui) {
                    var sorted_data = [];
                    $("#sort_images li").each(function (k, elem) {
                        const id = parseInt($(this).data('id'));
                        const order = k;
                        sorted_data.push({
                            id,
                            order
                        })
                    })
                    const response = await updatePortfolio({sorted_data});
                    if (response.status) {
                        toasterMsg({
                            heading: 'Success',
                            text: 'Images Re-ordered !!',
                            bg_color: '#62f764'
                        });
                        if(response.hasOwnProperty('data')){
                            if(response.hasOwnProperty('data') && response.data.images.length > 0){
                                 $('#portfolio_images').html('')
                                response.data.images.map(image => {
                                    const appendImage = `<div class="porfolio-image col-sm-4 mb-4"><img src="${response.data.base_url+'/'+image.name}" /></div>`
                                    $('#portfolio_images').append(appendImage)
                                })
                            }
                        }
                    }
                }
            }).disableSelection();
        });
    </script>
@endsection
@endsection
