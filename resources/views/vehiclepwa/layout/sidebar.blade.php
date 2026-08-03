<div class="menu-header"></div>

<div class="menu-items mb-4">
    <h5 class="text-uppercase opacity-20 font-12 pl-3">Menu</h5>
    <!-- <a id="nav-features" href="index-components.html">
        <i data-feather="heart" data-feather-line="1" data-feather-size="16" data-feather-color="red-dark" data-feather-bg="red-fade-light"></i>
        <span class="new-family">{{ __('messages.profile') }}</span>
        <i class="fa fa-circle"></i>
    </a> -->
    <a id="nav-features" href="">
       <i class="bi bi-person-circle fs-5"></i>
        <span class="new-family fw-600">Profile</span>
        <i class="fa fa-circle"></i>
    </a>

    

    <a id="nav-pages" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20"
            viewBox="0 0 30 30">
            <image
                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAATJJREFUSEvtlr9KA0EQxr9ZSQp7O/UFclsEtBILtTIPEhDR0ze5i1WeRBsbEQW1ye2R2J+g+ApJ+KJFAomne3twd0Ky7czsj/nmz66goiMVcfE/wDrULZJdEdnMowTJN1mTtjkz17b4uYy9wEvyQmcgQWLOzbYTWIeatoAsduMbawnnHFbgLLKm+Sy31I2wcaeg1qUuregk+pwqVHhzfe2GJwC7BGNVV0dTeOHgZqe5MeTwViAaxOuIo8PB5eC9cPC3tGlwZzDBvdiPH/7qeOs+IF6cwYpqv3fRuy8dnGW2F+d4UepxbXzgnLErOA3aP+1/FA7WgX6GYKf0cfIC71FEaqUvkN9KU7jUK3Bpj0Qmqav77F3pYxBdEFtZFsUPH0EilHbkRze2eOtv0HZBXvvygScH+sGEIutncAAAAABJRU5ErkJggg=="
                x="0" y="0" width="20" height="20" />
        </svg>
        <span class="new-family fw-600">Logout</span>
        <i class="fa fa-circle"></i>
    </a>
    <form id="logout-form" action="" method="POST" class="d-none">
        @csrf
    </form>
    <a href="#" class="close-menu">
        <i class="bi bi-x-lg text-danger"></i>
        <span class="new-family fw-600">Close</span>
        <i class="fa fa-circle"></i>
    </a>
</div>
