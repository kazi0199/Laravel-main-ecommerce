@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Categories Information Edit</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.categories.add') }}">
                        <div class="text-tiny">Categories</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Categories</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Categories Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="categories name" name="name"
                        tabindex="0" value="{{ $category->name }}" aria-required="true" required="">
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Categories Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="categories Slug" name="slug"
                        tabindex="0" value="{{ $category->slug }}" aria-required="true" required="">
                </fieldset>
                <fieldset>
                    <div class="body-title">Previous Image</div>
                    <img src="{{ asset('uploads/categories/'.$category->image) }}" alt="" class="image" height="70px" width="90px">
                </fieldset>
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="upload-1.html" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

