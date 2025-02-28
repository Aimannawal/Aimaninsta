<x-app-layout>
    {{-- Header --}}
    <div class="max-w-xl mx-auto mt-6 px-4">
        <div class="flex justify-between items-center mb-4">
            <div class="bg-white rounded-lg px-6 py-2 shadow-sm">
                <h2 class="font-bold">Latest Post</h2>
            </div>
            <div x-data="{ showModal: false, showLoginPopup: false }">
                @auth
                <button @click="showModal = true" class="bg-blue-500 text-white p-2 rounded-sm">
                    <i class="fas fa-upload p-1"></i>
                </button>
                <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg w-96">
                        @csrf
                        <h2 class="text-lg font-semibold mb-4">Upload File</h2>
            
                        <input type="file" name="image" class="w-full mb-3 border p-2 rounded" required>
                        <input type="text" name="caption" placeholder="Enter caption" class="w-full mb-3 border p-2 rounded" required>
                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="showModal = false" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
                        </div>
                    </form>                    
                </div>
                @endauth
            
                @guest
                <button @click="showLoginPopup = true" class="bg-blue-500 text-white p-2 rounded-sm">
                    <i class="fas fa-upload p-1"></i>
                </button>
                <div x-show="showLoginPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                        <h2 class="text-lg font-semibold mb-4">Anda belum login</h2>
                        <p class="text-gray-600 mb-4">Silakan login untuk mengunggah postingan.</p>
                        <div class="flex justify-center space-x-2">
                            <button @click="showLoginPopup = false" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
                        </div>
                    </div>
                </div>
                @endguest
            </div>            
        </div>

        {{-- Post Card --}}
        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-lg p-4 mb-4">
                <div class="flex items-center justify-between p-3 border-b">
                    <div class="font-medium ml-3">{{ $post->user->name }}</div>
                    <div x-data="{ showOptions: false }" class="relative">
                        <button @click="showOptions = !showOptions"><i class="fa-solid fa-ellipsis text-gray-600 mr-3"></i></button>
                        <div x-show="showOptions" @click.away="showOptions = false" class="absolute right-0 bg-white border rounded shadow-md">
                            @if(auth()->id() === $post->user_id)
                            <div x-data="{ showEditModal: false }">
                                <button @click="showEditModal = true" class="block w-full text-left px-4 py-2 text-sm">Edit</button>
                                
                                <div x-show="showEditModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <h2 class="text-lg font-semibold mb-4">Edit Post</h2>
                            
                                            <input type="file" name="image" class="w-full mb-3 border p-2 rounded">
                                            <input type="text" name="caption" value="{{ $post->caption }}" class="w-full mb-3 border p-2 rounded" required>
                            
                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="showEditModal = false" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                                            </div>
                                        </form>                    
                                    </div>
                                </div>
                            </div>
                            
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600">Delete</button>
                            </form>  
                            @endif                          
                        </div>
                    </div>
                </div>

                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg mt-3">

                <div class="p-3">
                    <div class="flex space-x-2 mb-2">
                        <form action="{{ route('likes.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit">
                                @if($post->likes()->where('user_id', auth()->id())->exists())
                                    <i class="fa-solid fa-heart text-xl text-red-500"></i>
                                @else
                                    <i class="fa-regular fa-heart text-xl"></i>
                                @endif
                            </button>
                        </form>                                               
                        <div x-data="{ showComments: false }">
                            <button @click="showComments = true"><i class="fa-regular fa-comment text-xl"></i></button>
                            <div x-show="showComments" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-md flex flex-col h-[80vh] max-h-[600px]">
                                    <div class="flex items-center justify-between p-4 border-b">
                                        <h2 class="text-lg font-semibold">Comments</h2>
                                        <button @click="showComments = false" class="text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="flex-1 overflow-y-auto p-2">
                                        @foreach ($post->comments as $comment)
                                            <div class="flex flex-col space-y-1 p-3 bg-gray-50 rounded-lg">
                                                <span class="font-bold text-sm">{{ $comment->user->name }}</span>
                                                <p class="text-sm text-gray-800">{{ $comment->text }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="p-4 border-t">
                                        <form action="{{ route('comments.store') }}" method="POST" class="w-full flex space-x-2">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <textarea 
                                                name="text" 
                                                placeholder="Add a comment..." 
                                                class="flex-1 border rounded-lg p-2 text-sm resize-none focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                                                required
                                            ></textarea>
                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Post</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="text-sm font-medium mb-1">{{ $post->likes->count() }} Likes</div>
                    <div class="text-sm">
                        <span class="font-medium">{{ $post->user->name }}</span>
                        <span>{{ $post->caption }}</span>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
