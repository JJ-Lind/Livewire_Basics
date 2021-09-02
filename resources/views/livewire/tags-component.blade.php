<div class='mt-4'>
    <div class='w-1/2 border-gray-300 rounded-md px-4 py-2'
         wire:ignore
         x-data
         x-init='
                 new Taggle($el, {
                    tags: @json($tags),
                    onTagAdd: function(e, tag) {
                        Livewire.emit("tagAdded", tag)
                   },
                   onTagRemove: function(e, tag) {
                        Livewire.emit("tagRemoved", tag)
                   }
               })
               Livewire.on("tagAddedFromBackend", tag => {
                    alert("Tag was added: " + tag);
               })
            '/>
</div>
