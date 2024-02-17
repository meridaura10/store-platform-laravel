<div class="flex justify-between items-center mt-6">
    <h2 class="text-3xl font-bold">
        {{ $category->title }}
    </h2>
    <div>
        <img class="h-[100px] rounded-full object-contain" src="{{ $category->image->url }}" alt="category image">
    </div>
</div>
