<nav class="fixed top-0 z-50 w-full bg-[#2E7D32]">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-4 text-sm text-green-700 rounded-lg sm:hidden hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-700">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-8 h-8" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="/admin" class="flex ms-2 md:me-24">
                    <img src="{{ asset('assets/logo/logo.png') }}" class="h-8 me-3" alt="Sayur Kita Logo" />
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">Sayur Kita</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm bg-[#2E7D32] rounded-full focus:ring-4 focus:ring-green-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="{{ asset('assets/logo/logo.png') }}" alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-[#2E7D32] divide-y divide-white rounded-sm shadow-sm" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-white" role="none">
                                Sayur Kita  
                            </p>
                            <p class="text-sm font-medium text-white" role="none">
                                sayurkita@gmail.com
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-green-600" role="menuitem">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-[#A2D77C] sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-[#A2D77C]">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/admin" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/admin_banner" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 32 32">
                        <path
                            d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM6.016 24q0 0.832 0.576 1.44t1.408 0.576h16q0.832 0 1.408-0.576t0.608-1.44v-0.928q-0.224-0.448-1.12-2.688t-1.6-3.584-1.28-2.112q-0.544-0.576-1.12-0.608t-1.152 0.384-1.152 1.12-1.184 1.568-1.152 1.696-1.152 1.6-1.088 1.184-1.088 0.448q-0.576 0-1.664-1.44-0.16-0.192-0.48-0.608-1.12-1.504-1.6-1.824-0.768-0.512-1.184 0.352-0.224 0.512-0.928 2.24t-1.056 2.56v0.64zM6.016 9.024q0 1.248 0.864 2.112t2.112 0.864 2.144-0.864 0.864-2.112-0.864-2.144-2.144-0.864-2.112 0.864-0.864 2.144z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Banner</span>
                </a>
            </li>
            <li>
                <a href="/admin_category" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 32 32">
                        <path id="list--checkbox_1_"
                            d="M7,31.36H1c-0.199,0-0.36-0.161-0.36-0.36v-6c0-0.199,0.161-0.36,0.36-0.36h6 c0.199,0,0.36,0.161,0.36,0.36v6C7.36,31.199,7.199,31.36,7,31.36z M1.36,30.64h5.28v-5.28H1.36V30.64z M31,28.36H11v-0.72h20V28.36 z M7,19.36H1c-0.199,0-0.36-0.161-0.36-0.36v-6c0-0.199,0.161-0.36,0.36-0.36h6c0.199,0,0.36,0.161,0.36,0.36v6 C7.36,19.199,7.199,19.36,7,19.36z M1.36,18.64h5.28v-5.28H1.36V18.64z M31,16.36H11v-0.72h20V16.36z M7,7.36H1 C0.801,7.36,0.64,7.199,0.64,7V1c0-0.199,0.161-0.36,0.36-0.36h6c0.199,0,0.36,0.161,0.36,0.36v6C7.36,7.199,7.199,7.36,7,7.36z M1.36,6.64h5.28V1.36H1.36V6.64z M31,4.36H11V3.64h20V4.36z">
                        </path>
                        <rect id="_Transparent_Rectangle" style="fill:none;" width="32" height="32"></rect>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Category</span>
                </a>
            </li>
            <li>
                <a href="/admin_product" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 60 60">
                        <path
                            d="M10.553,27.865c0-1.647,0.488-3.231,1.395-4.572c-0.298-0.962-0.452-1.97-0.452-2.969c0-4.308,2.715-8.061,6.651-9.47 c0.351-3.212,2.411-5.976,5.314-7.299c-1.492-2.415-3.847-3.831-6.018-3.479c-1.569,0.255-2.869,1.321-3.633,2.93 c-1.375-0.632-2.805-0.737-4.059-0.296C8.394,3.188,7.34,4.21,6.703,5.665c-0.845,1.927-0.846,4.407-0.029,6.765 c-1.101,0.756-1.924,1.867-2.405,3.26c-0.809,2.339-0.539,5.161,0.74,7.746c0.14,0.282,0.293,0.562,0.46,0.837 c-1.201,0.781-2.1,1.939-2.582,3.352c-0.766,2.242-0.427,4.884,0.93,7.246c0.623,1.085,1.448,2.068,2.409,2.876 c-0.321,1.344-0.078,2.821,0.704,4.158c1.093,1.865,3.062,3.13,5.166,3.343c2.818,5.296,6.224,7.998,11.095,10.339 c-5.787-6.841-9.005-12.507-9.186-21.051C11.875,33.015,10.553,30.516,10.553,27.865z">
                        </path>
                        <path
                            d="M55.083,20.053c0.08-3.894-2.207-7.397-5.751-8.911c-0.517-3.323-3.195-5.92-6.523-6.36 c-0.03-0.331-0.093-0.661-0.188-0.987c-0.587-2.004-2.354-3.513-4.395-3.755c-1.335-0.159-2.597,0.176-3.64,0.909 c-0.93-0.615-2.013-0.947-3.123-0.947c-2.859,0-5.235,2.112-5.649,4.858c-3.269,0.66-5.72,3.573-5.72,6.981 c0,0.183,0.008,0.366,0.022,0.552c-3.79,0.682-6.62,3.975-6.62,7.932c0,1.144,0.247,2.278,0.721,3.321 c-1.065,1.139-1.663,2.638-1.663,4.22c0,2.364,1.358,4.508,3.445,5.54c-0.092,9.063,3.209,14.565,9.649,21.979l0.363,0.413 l0.066,0.075c0.976,1.095,2.381,1.697,3.958,1.697c0.273,0,0.542-0.023,0.807-0.057L30.5,56.849 c-2.149-5.111-3.468-9.649-4.204-13.683c-2.773-0.854-3.972-3.07-4.025-3.172c-0.258-0.488-0.069-1.094,0.419-1.351 c0.485-0.257,1.088-0.071,1.349,0.414c0.037,0.069,0.619,1.093,1.892,1.791c-0.348-2.617-0.449-5.007-0.348-7.161 c-0.012-0.109-0.007-0.216,0.018-0.326c0.174-3.079,0.736-5.685,1.478-7.869c-3.369-2.009-3.785-5.749-3.495-7.564 c0.087-0.545,0.601-0.922,1.145-0.83c0.545,0.087,0.916,0.598,0.831,1.142c-0.025,0.161-0.474,3.478,2.254,5.344 c0.136-0.315,0.273-0.628,0.415-0.921c2.63-5.428,6.389-8.129,7.844-9.02c-0.003-2.003,1.31-3.743,1.372-3.824 c0.335-0.439,0.965-0.521,1.401-0.187c0.438,0.335,0.522,0.962,0.188,1.4c-0.223,0.296-0.661,1.033-0.857,1.844 c2.303-0.261,4.551,1.039,4.665,1.107c0.477,0.281,0.634,0.894,0.354,1.369c-0.187,0.316-0.521,0.492-0.862,0.492 c-0.173,0-0.347-0.044-0.506-0.138c-0.697-0.407-2.819-1.306-4.273-0.61c-0.253,0.129-1.955,1.045-3.892,3.066 c3.967-0.289,6.726,0.889,6.865,0.949c0.505,0.223,0.735,0.813,0.514,1.318c-0.165,0.374-0.532,0.598-0.917,0.598 c-0.133,0-0.269-0.026-0.399-0.084c-0.075-0.032-3.458-1.434-7.942-0.501c-0.898,1.263-1.762,2.777-2.478,4.581 c-0.002,0.132-0.029,0.266-0.087,0.394c-0.038,0.085-0.089,0.159-0.145,0.227c-0.569,1.559-1.028,3.312-1.304,5.292 c2.261-1.418,5.113-1.48,5.276-1.482c0.004,0,0.008,0,0.012,0c0.546,0,0.991,0.438,0.999,0.986 c0.008,0.552-0.434,1.005-0.985,1.014c-0.042,0.001-4.157,0.097-5.557,2.484c-0.098,2.439,0.071,5.162,0.591,8.192 c0.005,0.023,0.008,0.046,0.011,0.07c0.7,4.039,2.016,8.61,4.197,13.799l0.476,0.918c0.734-0.37,1.366-0.882,1.817-1.512 c0.753-1.052,0.931-2.328,0.499-3.593c-1.808-5.305-1.752-9.353,0.166-12.033c2.486-3.475,7.664-3.994,10.528-3.994 c1.475,0,2.488,0.136,2.498,0.138l1.028,0.14l0.103-1.032c0.014-0.136,0.309-3.358-1.571-5.547 c-0.109-0.127-0.224-0.247-0.342-0.362c0.531-0.119,1.056-0.288,1.572-0.506C52.652,27.113,55.006,23.751,55.083,20.053z">
                        </path>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                </a>
            </li>
            <li>
                <a href="/admin_blog" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 1H1v18h18V1H3zm14 2v14H3V3h14zm4 18H5v2h18V5h-2v16zM15 5H5v2h10V5zM5 9h10v2H5V9zm7 4H5v2h7v-2z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Blog</span>
                </a>
            </li>
            <li>
                <a href="/admin_gallery" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Gallery</span>
                </a>
            </li>
            <li>
                <a href="/admin_account" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 18">
                        <path
                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Accounts</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-black-900 rounded-lg hover:bg-white group">
                    <svg class="w-5 h-5 text-black-500 transition duration-75 group-hover:text-black-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
