<aside class="sidebar" id="sidebar">
    <div class="sidebar-top">
        <div class="site-logo">
            <a href="{{route('admin.dashboard')}}">
                <img src="{{ displayImage(getArrayValue($setting->logo, 'white'), "592x89") }}" class="mx-auto" alt="{{ __('White Logo') }}">
            </a>
        </div>
    </div>

    <div class="sidebar-menu-container" data-simplebar>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('agent.dashboard') ? "active" :""}}" href="{{route('agent.dashboard')}}">
                    <span><i class="las la-cog"></i></span>
                    <p>{{ __('admin.dashboard.menu.name') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('agent.transaction-logs') ? "active" :""}}" href="{{route('agent.transaction-logs')}}">
                    <span><i class="las la-file-invoice"></i></span>
                    <p>{{ __('Transaction Logs') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('agent.investment-logs') ? "active" :""}}" href="{{route('agent.investment-logs')}}">
                    <span><i class="las la-dollar-sign"></i></span>
                    <p>{{ __('User Investments') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('agent.withdraw.now') ? "active" :""}}" href="{{route('agent.withdraw.now')}}">
                    <span><i class="las la-credit-card"></i></span>
                    <p>{{ __('Withdraw Now') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('agent.withdraw.index') ? "active" :""}}" href="{{route('agent.withdraw.index')}}">
                    <span><i class="las la-history"></i></span>
                    <p>{{ __('Withdraw Logs') }}</p>
                </a>
            </li>
        </ul>
    </div>
</aside>


@push('script-push')
    <script>
        "use strict";
        (function(){
            const htmlRoot = document.documentElement;
            const sidebarControlBtn = document.querySelector('.sidebar-control-btn');
            const menuTitle = document.querySelectorAll('.sidebar-menu-title');
            const minWidth = 1199;

            window.addEventListener("DOMContentLoaded", () => {
                handleSetAttribute(htmlRoot, 'data-sidebar', "lg");
                handleResize();

                sidebarControlBtn.addEventListener("click", () => {
                    const windowWidth = window.innerWidth;
                    if (windowWidth <= minWidth) {
                        showSidebar();
                        createOverlay();
                    } else {
                        handleSidebarToggle();
                    }
                });
            });

            function createOverlay() {
                const overlay = document.createElement('div');
                overlay.setAttribute("id", "overlay-wrapper");

                overlay.style.cssText = `
                    position: fixed;
                    inset: 0;
                    width: 100%;
                    height: 100vh;
                    background: rgb(0 0 0 / 20%);
                    z-index: 19;
                `;
                document.body.appendChild(overlay);

                overlay.addEventListener("click", () => {
                    hideSidebar();
                    removeOverlay();
                });
            }

            function removeOverlay() {
                const overlayWrapper = document.querySelector("#overlay-wrapper")
                overlayWrapper && overlayWrapper.remove();
            }

            function handleSetAttribute(elem, attr, value = 'lg') {
                elem.setAttribute(attr, value);
            }

            function handleGetAttribute(elem, attr) {
                return elem.getAttribute(attr);
            }

            function showSidebar() {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.transform = 'translateX(0%)';
                    sidebar.style.visibility = 'visible';
                }
            }

            function hideSidebar() {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebar.style.visibility = 'hidden';
                }
            }

            function handleSidebarToggle() {
                const currentSidebar = handleGetAttribute(htmlRoot, 'data-sidebar');
                const newAttributes = currentSidebar === 'sm' ? 'lg' : 'sm';

                handleSetAttribute(htmlRoot, 'data-sidebar', newAttributes);

                for (const title of menuTitle) {
                    const dataText = title.getAttribute('data-text');
                    title.innerHTML = newAttributes === 'sm' ? '<i class="las la-ellipsis-h"></i>' : dataText;
                }
            }

            function handleResize() {
                const windowWidth = window.innerWidth;
                if (windowWidth <= minWidth) {
                    handleSetAttribute(htmlRoot, 'data-sidebar', "lg");
                    hideSidebar();
                    removeOverlay();
                } else {
                    removeOverlay();
                    showSidebar();
                }
            }

            window.addEventListener('resize', handleResize);
            if (document.querySelectorAll(".sidebar-menu .collapse")) {
                const collapses = document.querySelectorAll(".sidebar-menu .collapse");
                Array.from(collapses).forEach(function (collapse) {
                    const collapseInstance = new bootstrap.Collapse(collapse, {
                        toggle: false,
                    });
                    collapse.addEventListener("show.bs.collapse", function (e) {
                        e.stopPropagation();
                        const closestCollapse = collapse.parentElement.closest(".collapse");
                        if (closestCollapse) {
                            const siblingCollapses = closestCollapse.querySelectorAll(".collapse");
                            Array.from(siblingCollapses).forEach(function (siblingCollapse) {
                                const siblingCollapseInstance = bootstrap.Collapse.getInstance(siblingCollapse);
                                if (siblingCollapseInstance === collapseInstance) {
                                    return;
                                }
                                siblingCollapseInstance.hide();
                            });
                        } else {
                            const getSiblings = function (elem) {
                                const siblings = [];
                                let sibling = elem.parentNode.firstChild;
                                while (sibling) {
                                    if (sibling.nodeType === 1 && sibling !== elem) {
                                        siblings.push(sibling);
                                    }
                                    sibling = sibling.nextSibling;
                                }
                                return siblings;
                            };
                            const siblings = getSiblings(collapse.parentElement);
                            Array.from(siblings).forEach(function (item) {
                                if (item.childNodes.length > 2)
                                    item.firstElementChild.setAttribute("aria-expanded", "false");
                                const ids = item.querySelectorAll("*[id]");
                                Array.from(ids).forEach(function (item1) {
                                    item1.classList.remove("show");
                                    if (item1.childNodes.length > 2) {
                                        const val = item1.querySelectorAll("ul li a");
                                        Array.from(val).forEach(function (subitem) {
                                            if (subitem.hasAttribute("aria-expanded"))
                                                subitem.setAttribute("aria-expanded", "false");
                                        });
                                    }
                                });
                            });
                        }
                    });

                    collapse.addEventListener("hide.bs.collapse", function (e) {
                        e.stopPropagation();
                        const childCollapses = collapse.querySelectorAll(".collapse");
                        Array.from(childCollapses).forEach(function (childCollapse) {
                            let childCollapseInstance;
                            childCollapseInstance = bootstrap.Collapse.getInstance(childCollapse);
                            childCollapseInstance.hide();
                        });
                    });
                });
            }

        }());
    </script>
@endpush





