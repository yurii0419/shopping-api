<div>
    <form wire:submit.prevent="addProduct" enctype="multipart/form-data">
        <div class="container py-5">
            <div class="display-1 tertiary-color">List an item</div>
            <div class="row">
                <div class="col-6">
                    <div class="photo-upload-container">
                        <div class="photo-upload-wrapper">
                            <div class="photo-upload-heading">
                                <div class="h2 tertiary-color">Photos</div>
                                <h6>Add up to 6 photos. <a href=""> Here's how to take a good </a></h6>
                            </div>
                            <div class="photo-upload-grid">
                                @foreach (range(1, 6) as $item)
                                    <div class="photo-upload">
                                        <label class="photo-upload-label">
                                            <input type="file" name="image" id="image-upload-{{$item}}" style="display: none;" wire:model="images.{{$item}}" wire:ignore>
                                            <img class="img-fluid" id="image-preview-{{$item}}" src="{{ asset('assets/img/profile_listing/photo_holder.jpg') }}" alt="" wire:ignore>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="product-info-container">
                        <div class="product-info-wrapper">
                            <div class="product-name-container pb-4">
                                <h1 class="tertiary-color">Product Name</h1>
                                <div class="product-input position-relative" x-data="{name:''}">
                                    <input type="text" x-model="name" wire:model="product_name" maxlength="50">
                                    <span class="text-limit"> <span x-text="name.length"></span>/50</span>
                                </div>
                            </div>
                            <div class="product-description-container">
                                <div class="product-description-wrapper">
                                    <div class="product-description-heading">
                                        <h1 class="tertiary-color">Description</h1>
                                        <p class="m-0">Tell us about your unique item!</p>
                                        <a href=""> Here are some tips for making a description</a>
                                    </div>
                                    <div class="product-description-input position-relative" x-data="{text:''}">
                                        <textarea name="textarea" x-model="text" wire:model="product_description" maxlength="200"></textarea>
                                        <div class="text-limit"><span x-text="text.length"></span>/200</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row py-4">
                <div class="col-6">
                    <div class="price-container">
                        <div class="price-wrapper">
                            <div class="price-input-container">
                                <h2 class="fw-bold tertiary-color">Price</h2>
                                <label class="price-label position-relative">
                                    <span class="price-icon"><i class="fa-solid fa-peso-sign"></i></span>
                                    <input type="number" step="0.01" wire:model="price">
                                </label>
                            </div>
                            <div class="accept-offer-container d-flex">
                                <div class="accept-offer-wrapper">
                                    <input type="checkbox" class="checkbox" id="checkbox" wire:model="listings">
                                    <label class="switch" for="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="accept-offer-info">
                                    <h2 class="fw-bold tertiary-color">Accept offers</h2>
                                    <p class="m-0 w-75">Let buyers make an offer at a different price in buying the product
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="tags-container">
                        <div class="tags-wrapper d-flex flex-column">
                            <h3 class="fw-bold tertiary-color">
                                Tags
                            </h3>
                            <p class="fw-medium tertiary-color">Let more people discover this!</p>
                            <a href="">Tag tips</a>
                            <label class="d-flex flex-column position-relative">
                                {{-- <select wire:model="tags" name="tags" id="tags" multiple>
                                    <option value="">Select Tags (You can select multiple tags)</option>
                                    @if ($keywords)
                                        @foreach ($keywords as $key => $keyword)
                                            <option value="{{ $keyword }}">{{ $keyword }}</option>
                                        @endforeach
                                    @endif
                                </select> --}}
                                <input type="text" wire:model="tags">
                                <span class="limit-text position-absolute">0/10</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row py-4">
                <div class="col-6">
                    <div class="about-item-container">
                        <div class="about-item-wrapper d-flex flex-column" style="row-gap: 1rem;">
                            <h3 class="fw-bold tertiary-color">About the Item</h3>

                            <div class="category-select">
                                <select wire:model="category_id" wire:change="fetchSubcategories($event.target.value)" name="category_id" class="form-select" aria-label="Default select example">
                                    <option class="muted-color">Category</option>
                                    @if ($categories)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No categories available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="Subcategory-select">
                                <select wire:model="subcategory_id" wire:change="fetchSubsubCategories($event.target.value)" class="form-select" name="subcategory_id" aria-label="Default select example">
                                    <option class="muted-color">Subcategory</option>
                                    @if ($subcategories)
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No subcategories available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="Subcategory-select">
                                <select wire:model="sub_subcategory_id" class="form-select" aria-label="Default select example">
                                    <option class="muted-color">Sub Subcategory</option>
                                    @if ($subsubcategories)
                                        @foreach ($subsubcategories as $subsubcategory)
                                            <option value="{{ $subsubcategory->id }}">{{ $subsubcategory->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No subcategories available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="Condition-select">
                                <select wire:model="condition" class="form-select" aria-label="Default select example">
                                    <option>Condition</option>
                                    @if ($conditions)
                                        @foreach ($conditions as $key => $condition)
                                            <option value="{{ $condition }}">{{ $condition }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No conditions available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="Size-select">
                                <select class="form-select" wire:model="size" aria-label="Default select example">
                                    <option class="muted-color">Size</option>
                                    @if ($sizes)
                                        @foreach ($sizes as $key => $size)
                                            <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="listing-container">
                        <div class="listing-wrapper d-flex flex-column" style="row-gap: 1rem;">
                            <h3 class="fw-bold tertiary-color">
                                Enhance listing
                            </h3>

                            <div class="Color-select">
                                <select wire:model="color" class="form-select" aria-label="Default select example">
                                    <option>Color</option>
                                    @if ($colors)
                                        @foreach ($colors as $key => $color)
                                            <option value="{{ $color }}">{{ $color }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No colors available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="Brand-select">
                                <!-- Product Brand -->
                                <select wire:model="product_brand" class="form-select" aria-label="Default select example">
                                    <option class="muted-color">Brand</option>
                                    @if ($brands)
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No brands available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="Style-select">
                                <select wire:model="style" class="form-select" aria-label="Default select example">
                                    <option>Styles</option>
                                    @if ($styles)
                                        @foreach ($styles as $key => $style)
                                            <option value="{{ $style }}">{{ $style }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No styles available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="measurement-container py-4">
                <div class="measurement-wrapper">
                    <div class="measurement-heading pb-4">
                        <div class="head-wrapper d-flex justify-content-between">
                            <div><span class=" h3 fw-bold tertiary-color">Measurements</span>
                                <span class="muted-color h3">(Optional)</span>
                            </div>

                            <div class="guide-link"><a href="">Guide <span><i class="fa-solid fa-arrow-right"></i></span></a></div>
                        </div>
                        <p>You've got a 40% better chance of selling this item if you add measurements. Include as many as
                            applicable.</p>
                    </div>

                    <div class="measurement-unit">
                        <div class="unit-wrapper">
                            <input type="radio" id="in" checked name="check-substitution-2" value="in" wire:change="measurements($event.target.value)" />
                            <label class="btn btn-default fs-lg " for="in">In</label>
                        </div>
                        <div class="unit-wrapper">
                            <input type="radio" id="cm" name="check-substitution-2" value="cm" wire:change="measurements($event.target.value)" />
                            <label class="btn btn-default fs-lg " for="cm">Cm</label>
                        </div>
                    </div>

                    <div class="clothe-unit-container pt-4">
                        <div class="clothe-unit-wrapper">
                            <div class="clothe-container">
                                <h3>Chest</h3>
                                <label class="position-relative">
                                    <input type="number" wire:model="chest">
                                    <span class="clothe-unit">{{ $measurement }}</span>
                                </label>
                            </div>
                            <div class="clothe-container">
                                <h3>Shoulders</h3>
                                <label class="position-relative">
                                    <input type="number" wire:model="shoulders">
                                    <span class="clothe-unit">{{ $measurement }}</span>
                                </label>
                            </div>
                            <div class="clothe-container">
                                <h3>Sleeve length</h3>
                                <label class="position-relative">
                                    <input type="number" wire:model="sleeve_length">
                                    <span class="clothe-unit">{{ $measurement }}</span>
                                </label>
                            </div>
                            <div class="clothe-container">
                                <h3>Length</h3>
                                <label class="position-relative">
                                    <input type="number" wire:model="length">
                                    <span class="clothe-unit">{{ $measurement }}</span>
                                </label>
                            </div>
                            <div class="clothe-container">
                                <h3>Hem</h3>
                                <label class="position-relative">
                                    <input type="number" wire:model="hem">
                                    <span class="clothe-unit">{{ $measurement }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shipping-container py-4">
                <div class="shipping-wrapper">
                    <div class="shipping-heading">
                        <h3 class="fw-bold tertiary-color pb-3">
                            Shipping
                        </h3>
                    </div>
                    <div class="shipping-details-wrapper">
                        <div class="shipping-details">
                            <div class="main-info d-flex justify-content-between">
                                <p class="d-flex flex-column">
                                    <span class="muted-color fs-5 lh-1">{{$user->name}}</span>
                                    <span class="muted-color fs-5 lh-1">+63{{$user->phone_number}}</span>
                                    <span class="muted-color fs-5 lh-1">{{$user->address}}</span>
                                </p>
                                <div class="shipping-icon">
                                    <a href=""><i class="fa-solid fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="additional-info pt-3  border-bottom">
                                <span class="muted-color fs-5">
                                    Additional information
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="size-container py-4">
                <h3 class="fw-bold tertiary-color pb-3">Parcel Size</h3>
                <div class="size-wrapper">
                    <div class="row">
                        <div class="col-6">
                            <div class="shipping-size-style d-flex flex-column">
                                <div class="shipping-style">
                                    <h3>Weight</h3>
                                    <label class="position-relative">
                                        <input type="number">
                                        <span class="size-unit fs-lg">kg</span>
                                    </label>
                                </div>
                                <div class="dimension-style d-flex align-items-center">
                                    <div class="dimension-container d-flex justify-content-center align-items-center">
                                        <span class="fs-lg">L</span>
                                        <label>
                                            <input type="number">
                                            <span class="ps-2 fs-lg">cm</span>
                                        </label>
                                    </div>
                                    <div><span>X</span></div>
                                    <div class="dimension-container d-flex justify-content-center align-items-center">
                                        <span class="fs-lg">L</span>
                                        <label>
                                            <input type="number">
                                            <span class="ps-2 fs-lg">cm</span>
                                        </label>
                                    </div>
                                    <div><span>X</span></div>
                                    <div class="dimension-container d-flex justify-content-center align-items-center">
                                        <span class="fs-lg">L</span>
                                        <label>
                                            <input type="number">
                                            <span class="ps-2 fs-lg">cm</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="fee-style">
                                    <div class="shipping-style">
                                        <h3>Shipping fee</h3>
                                        <label class="position-relative">
                                            <input type="number">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cod-container d-flex flex-column">
                                <div class="cod-wrapper d-flex justify-content-between align-items-center">
                                    <span class="h3">Enable COD</span>
                                    <div class="cod-icon">
                                        <input type="checkbox" class="cod-checkbox" id="cod-checkbox">
                                        <label class="switch" for="cod-checkbox">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="cod-wrapper d-flex justify-content-between align-items-center">
                                    <span class="h3">Standard Local</span>
                                    <div class="standard-icon">
                                        <input type="checkbox" class="standard-checkbox" id="standard-checkbox">
                                        <label class="switch" for="standard-checkbox">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="cod-description">
                                    <p class="fs-5 fw-medium lh-1 tertiary-color">
                                        Shipping settings will be applicable for this product only. Shipping fees displayed
                                        are base rates and will be subject to change depending on buyer and seller location.
                                        Economy Local base rates shown are only applicable to sellers in Metro Manila (and
                                        select Luzon cities) for shipments to VisMin, which will be 30% cheaper than
                                        Standard Local. Kindly contact your Relationship Manager to know more about Economy
                                        Local and how to activate it.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cta-container mt-5">
            <div class="cta-wrapper d-flex justify-content-center">
                <div class="draft-btn-container">
                    <button>
                        Save as draft
                    </button>
                </div>
                <div class="list-btn-container">
                    <button type="submit">
                        List item
                    </button>
                </div>
            </div>
        </div>
    </form>

    @script
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                // var element = document.querySelector('#tags');
                // var choices = new Choices(element, { allowHTML: true });
                for (let i = 1; i <= 6; i++) {
                    document.getElementById(`image-upload-${i}`).addEventListener('change', function() {
                        displayImages(`image-upload-${i}`, `image-preview-${i}`);
                    });
                }
            });
        </script>
    @endscript

   <style>
        .is-invalid {
            border-color: red !important;
        }

        /* .tags-container input {
            border-radius: 0px !important;
            border: 1px solid transparent !important;
            padding: none !important;
            text-indent: 15px;
            width: 100% !important;
        }

        .choices__list--multiple .choices__item {
            background-color: #701D00 !important;
            border: 1px solid #701D00 !important;
        }

        .choices {
            border: 1px solid #701D00 !important;
            border-radius: 13px !important;
        }

        .choices__inner {
            border: 1px solid transparent !important;
            border-radius: 13px !important;
        }

        .choices__list--dropdown, .choices__list[aria-expanded]{
            border: 1px solid #701D00 !important;
            border-radius: 13px !important;
        } */
   </style>
</div>
