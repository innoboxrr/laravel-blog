<footer class="bg-white pt-8 mt-10">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-3 gap-x-0 md:gap-x-6">
            <div class="col-span-1">
                <div class="footer-section my-38px">
                    <h3 class="footer-section-title">
                        {{ __('Recent Comments') }}
                    </h3>
                    <ul class="footer-section-content">
                        <li class="footer-section-content-response">
                            <img
                                class=" footer-section-content-img"
                                src="data:image/webp;base64,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"
                                alt="Profile Picture"
                                width="56"
                                height="56"
                                >
                            <div class="footer-section-content-response-wrapper">
                                <h4>
                                    <span class="text-secondary">Jobby Foster</span> in 
                                    <a href="#" class="response-subject light-link underline" title="Subject Response">
                                    Want to learn Javascript in 2022?
                                    </a>
                                </h4>
                                <p class="font-primary mt-2.5">Love this guy and his dog, really nice work!</p>
                            </div>
                        </li>
                        <li class="footer-section-content-response">
                            <img
                                class=" footer-section-content-img"
                                src="data:image/webp;base64,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"
                                alt="Profile Picture"
                                width="56"
                                height="56"
                                >
                            <div class="footer-section-content-response-wrapper">
                                <h4>
                                    <span class="text-secondary">Sheryl Winarick</span> in 
                                    <a href="#" class="response-subject light-link underline" title="Subject Response">
                                    Want to learn Javascript in 2022?
                                    </a>
                                </h4>
                                <p class="font-primary mt-2.5">Love the way you did the background image man.</p>
                            </div>
                        </li>
                        <li class="footer-section-content-response">
                            <img
                                class=" footer-section-content-img"
                                src="data:image/webp;base64,UklGRnIHAABXRUJQVlA4WAoAAAAQAAAAbwAAbwAAQUxQSOUCAAABkDRb29o2r6QJQ5mZnBXDNltmjoO/oczc/gKPkrZeudtsy8zsMjMtmzEUPf6+d2GSvu99p9uImABQO6tscIf/zJMv01HE6PTn4Gn/jsGyLCB64dDEwxg6Gns4ObSQnIpDQYmuyuChSkKW732DSr7Zu5wEo/6EQGXFyXpDN3P4CSr+ZNjUyeh7gRq+7DO0qb6Fmt6q0WOGLVBbMTFDg5ZvqPW3FtXybYmaSztfKc9TJPCpR6G2MJIYblNmvUAixQY1TB8S6jMVsAJIasByzZpCYqcsl8wAkhsw3bGRYNuVrUjyVhda4zTJVsc8ISQ65HEo/ymS/SzfGRsJtx1plpTJZgdmfEPSv83IbAKJn8yoRlAnazIwbiD5N4z0epHB3rSsFxy8sNIZQhaH0jCe8fDcSFWPTNanOsHFyRQrBBdiRbI9yOa+ZG/4eJOkChmtSjjEyeGEB5wEAWCx5EQuBhhEVr0APl58AA95eQhZMV5iWeXIbOkQN96d3Oz0c+M/y83Z+9zc/8TNpxA3oQg3UfzvjXATDXET+sTN5wfc3D/LzVk/N/6d3Owc4maogpuyrBgvsSx4yMtDAB8vPgAvL16AxZITuRgAHnASBAA4zMnhhCpOqhLgDR9vIek+PvYnWyG4ECuSwUkuTkLKei7qUxnPeXhupIIhHoYhTeslBy+tdKCPgz5I27hJ300jPaiR1MlayPQIdUcg4xnfafs+IzNolZTJFnDSpswGR/Of0/U83xnwhKgKlYDT7ZIm2QXOb6VpK7hpU2SDq2aAnoDpDlhT1ExZ4LYVoCVggfumjxKfCUpuEFSIDaBqW5iGcAeo63lKwfMSUDl/Qr8j+aD2zIu6XZwJyreHdQq3g465x+K6xI/lgqbzTkgd5Il5oPGqs0I1cXYVaD7zyG+Vfh+ZCQRa3odCDfHQawGVOZsex9yKPd6UA8TWHX/316m/747XAdFzxv1X3k7/jcsEGf/74+0V//gcUBsAVlA4IGYEAAAQHACdASpwAHAAPp1EnkquKqmrKxLaALATiWQGKAEKyanWGaD9F50lk/wXD4oQ7fJw2208wHnCelT/R+lB1KvoS9Ltfs30V3C8Z1cTdnJwCtbwF4s71QNNJfUwpWhg6flwxFcdZvfhQ+TZKi/l1oeZecRlxC4y20XkOyvgqTc12d2LaMNJtYUoKR4+E6YzySJybX8TIwd1eYzhk8/Xeg3jDlraVWxXCO9nKmsmOlBLjAIZqgBr/Lc+ISpiuVj/nM/26wQcbeohnDQw4vICULCJNl4UhIveNZzkOjToITN43aOXDoe1Ht3dwAD+/Ph5+mmT/zEADT+yghr+juiNO5CuOS1iCFv6szl2Ey24/Mspututr5804jlUq9rmlEWZLbvHVvNI/q93//U2f/6lk//9R5KiS3Pc4WtM1GICi0G1/4a+konsOL7NXy/iBV2MWwyYE5rge/S1UkpQ8V3A+k6AVns6BJGnf6n67OXQRecng7/CLIqSYAx71742QkIvP+BkOQlPw5HR47f7tZDx9f3hkw1GXIrblE6mMk9rqkKz83W00vgCKAuajKAXmC+MixXeITDQSdGjf9yqFcBKy9NstlH0DtgR0nR8+bGg/fUs97aRcdr1xApq4cBqtgSRebmc9SsZoGJ9mWm17J65FhZHBvNnJMGOSpq/PflNRNmFYrhAiegpvbhfc8ivANQa1+DIWVwxxNMpWqpDYXOv7Ns8dzQk3m3jIaIqqatljM8xREBUdAlFIeDBLcoxn10TWfGyNmhHvgFit8WPHE88c4Y8exSwbY7dGNX0vDHcF9EhQAJYh+WtM54h2SItmO+t1xMXKgcX5yUasxF5GI/UZ9S9HDQyxHNgjbeaofL6NcBKzIEVblz/EfWLUwVN0JqE1UBzR2Tlt3JSvREUVlvh1OB+D/IBuw2A+6x2+9q9vU56u8n3I4r6tmV+viQMgzQjPymHu10hj2ltCY8wUTK0vq/GGGsuHXYF+zStyUpxxGNMwfQbXxHlHe5S85mRjbuD5MGPEr2hMfHKmniRaPgXBA45DcJDsE6M3Uib+TYId6bQx6uqbC3So6MBGpBtijLp6AR8E5oprxpih+Mcpg+LiVN59iGwjU3De/kVIKscZy7M5o4SfYkt/Ys1yW9j+4i9YWOwlTEHyiRwGb7FANBITGxR2YvVQ+hecBYuJA1z+7C5tlZCIQcWjX+LibDW7GQKEkyf6egzvjzdEyowyxT/RkgyyfTa6+bBZskwcBXg/2Z02O43wuEG7CeHivhRb/BcZerNoK6qX3eR53VXa/HKblwrwwZnMMUdcexncASP/MvMT9AH+BrBpu+8BEuNaZyOn5o4P7x9m/WPLl78DEtyOrs1qs9fsVGY8n9X7rhklnxHUjZ5AFLbRWzdqHTn8OawBRNxRaTZYkG9bJGVyNbOJNK83bFQqDgEcSXl/X3hDb4LtbnjHqiDUYnD7TKORsU0wtNUtKw//+qNnVAY/nsYKpLeiC+ISgAA" 
                                alt="Profile Picture"
                                width="56"
                                height="56"
                                >
                            <div class="footer-section-content-response-wrapper">
                                <h4>
                                    <span class="text-secondary">Jobby Foster</span> in 
                                    <a href="#" class="response-subject light-link underline" title="Subject Response">
                                    Want to learn Javascript in 2022?
                                    </a>
                                </h4>
                                <p class="font-primary mt-2.5">Really nice style. I need to take note for drawing people!</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-1">
                <div class="footer-section my-38px">
                    <h3 class="footer-section-title">Last Tweet</h3>
                    <ul class="footer-section-content">
                        <li class="footer-section-content-twitt">
                            <h4><a class="text-secondary hover:underline" href="#" title="microsoft">@microsoft</a></h4>
                            <time datetime="2022-12-31T23:59:59Z">3 days ago</time>
                            <p class="font-primary mt-2.5 mb-4">She's climbing #50Peaks in 50 states in 50 days. Meet 
                                <a href="#" title="" class="light-link">http://msft.it/Melissa</a>
                            </p>
                        </li>
                        <li class="footer-section-content-twitt">
                            <h4><a class="text-secondary hover:underline" href="#" title="microsoft">@microsoft</a></h4>
                            <time datetime="2022-12-31T23:59:59Z">3 days ago</time>
                            <p class="font-primary mt-2.5 mb-4">She's climbing #50Peaks in 50 states in 50 days. Meet 
                                <a href="#" title="" class="light-link">http://msft.it/Melissa</a>
                            </p>
                        </li>
                        <li class="footer-section-content-twitt">
                            <h4><a class="text-secondary hover:underline" href="#" title="microsoft">@microsoft</a></h4>
                            <time datetime="2022-12-31T23:59:59Z">3 days ago</time>
                            <p class="font-primary mt-2.5 mb-4">She's climbing #50Peaks in 50 states in 50 days. Meet 
                                <a href="#" title="" class="light-link">http://msft.it/Melissa</a>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-1">
                <div class="footer-section my-38px border-b border-solid border-secondBorderColor">
                    <img
                        class="mb-5.5 "
                        src="{{ $layoutData['logo'] }}" 
                        alt="Logo"
                        width="32"
                        height="32"
                        >
                    <div class="footer-section-content">
                        <p class="mb-9 mt-9 font-primary">
                            {!! $layoutData['blog.footer_text'] !!}
                        </p>
                    </div>
                </div>
                <div class="footer-section my-38px">
                    <h3 class="footer-section-title mb-34px">
                        {{ __('Newsletter') }}
                    </h3>
                    <div class="footer-section-content">
                        <p class="font-primary mt-2.5 mb-4">
                            {{ __('Stay up to do date with my posts, subscribe to newsletter:') }}
                        </p>
                        <form action="{{ route('api.larablog.blog_subscriber.create') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <input type="hidden" name="blog_subscriber_type" value="email">
                            <input type="email" class="form-control" placeholder="{{ __('Type Email') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright flex items-center justify-between flex-col md:flex-row-reverse border-t border-solid border-borderColor py-5">
            <ul class="flex gap-2">
                @foreach($layoutData['social_icons'] as $network => $icon)
                    @if(!empty($layoutData['blog.socias'][$network]))
                        <li>
                            <a 
                                href="{{ $layoutData['blog.socias'][$network] }}" 
                                class="social-icon"
                                title="{{ ucfirst(str_replace('-', ' ', $network)) }}"
                                target="_blank" 
                                rel="noopener noreferrer">
                                <i class="fab {{ $icon }}"></i>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <p class="font-primary mt-2 md:mt-0 text-center md:text-left">
                &copy; {{ __('Powered by') }}
                <a href="#" title="" class="text-secondary hover:underline">
                    {{ config('app.name') }}
                </a>. 
                {{ date('Y') }}. {{ __('All Rights Reserved.') }}
            </p>
        </div>
    </div>
</footer>