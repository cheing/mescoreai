<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <!-- iOS / Android: when added to the home screen, open without browser UI -->
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta
      name="apple-mobile-web-app-status-bar-style"
      content="black-translucent" />
    <meta name="theme-color" content="#000000" />
    <title>Live Streaming</title>
    <style>
      :root {
        --app-height: 100vh;
      }

      html,
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #000;
        overscroll-behavior: none;
        -webkit-text-size-adjust: 100%;
      }

      .stream-wrap {
        position: fixed;
        inset: 0;
        width: 100vw;
        height: var(--app-height); /* JS fallback for old iOS */
        height: 100dvh; /* follows the mobile address bar on rotate */
        background: #000;
      }

      .stream-wrap iframe {
        display: block;
        width: 100%;
        height: 100%;
        border: 0;
      }

      /* Force landscape: when the phone is held in portrait, rotate the
         player 90deg so it always shows landscape (iPhone can't lock
         orientation, and Android falls back to this if the lock fails). */
      @media (orientation: portrait) {
        .stream-wrap {
          inset: auto;
          top: 0;
          left: 0;
          width: var(--app-height);
          width: 100dvh;
          height: 100vw;
          transform-origin: top left;
          transform: rotate(90deg) translateY(-100%);
        }
      }

      /* Tap-to-start overlay (Android): fullscreen + landscape lock
         need a user tap, and taps inside the iframe don't reach us */
      .start-overlay {
        position: absolute;
        inset: 0;
        z-index: 20;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: rgba(0, 0, 0, 0.55);
        color: #fff;
        font: 600 16px/1.4 system-ui, -apple-system, sans-serif;
        text-align: center;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
      }

      .start-overlay.show {
        display: flex;
      }

      .start-overlay svg {
        width: 56px;
        height: 56px;
        fill: currentColor;
      }

      .start-overlay small {
        font-weight: 400;
        opacity: 0.8;
      }

      /* Back to home; above the start overlay so users can always leave */
      .back-btn {
        position: absolute;
        top: calc(10px + env(safe-area-inset-top));
        left: calc(10px + env(safe-area-inset-left));
        z-index: 30;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.45);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.7;
        transition: opacity 0.2s;
        -webkit-tap-highlight-color: transparent;
      }

      .back-btn:hover,
      .back-btn:focus-visible {
        opacity: 1;
      }

      .back-btn svg {
        width: 24px;
        height: 24px;
        fill: currentColor;
      }

      .fs-btn {
        position: absolute;
        top: calc(10px + env(safe-area-inset-top));
        right: calc(10px + env(safe-area-inset-right));
        z-index: 10;
        width: 40px;
        height: 40px;
        padding: 0;
        border: 0;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.45);
        color: #fff;
        cursor: pointer;
        display: none; /* shown by JS only when fullscreen is supported */
        align-items: center;
        justify-content: center;
        opacity: 0.7;
        transition: opacity 0.2s;
        -webkit-tap-highlight-color: transparent;
      }

      .fs-btn:hover,
      .fs-btn:focus-visible {
        opacity: 1;
      }

      .fs-btn svg {
        width: 22px;
        height: 22px;
        fill: currentColor;
      }

      .fs-btn .icon-exit {
        display: none;
      }

      .is-fullscreen .fs-btn .icon-enter {
        display: none;
      }

      .is-fullscreen .fs-btn .icon-exit {
        display: block;
      }
    </style>
  </head>
  <body>
    <div class="stream-wrap" id="streamWrap">
      <iframe
        src="https://me88livestreaming.com/live?mode=s1"
        title="Live Streaming"
        frameborder="0"
        allow="
          accelerometer;
          autoplay;
          clipboard-write;
          encrypted-media;
          gyroscope;
          picture-in-picture;
          web-share;
          fullscreen;
          screen-wake-lock;
        "
        scrolling="no"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen
        webkitallowfullscreen
        mozallowfullscreen></iframe>

      <div class="start-overlay" id="startOverlay" role="button">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path
            d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
        </svg>
        <div>点击全屏观看<br /><small>Tap to watch fullscreen</small></div>
      </div>

      <a class="back-btn" href="{{ url('/') }}" aria-label="Back">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>

      <button class="fs-btn" id="fsBtn" type="button" aria-label="Fullscreen">
        <svg class="icon-enter" viewBox="0 0 24 24" aria-hidden="true">
          <path
            d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
        </svg>
        <svg class="icon-exit" viewBox="0 0 24 24" aria-hidden="true">
          <path
            d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
        </svg>
      </button>
    </div>

    <script>
      (function () {
        var wrap = document.getElementById("streamWrap");
        var btn = document.getElementById("fsBtn");

        // Fallback height for browsers without dvh (older iOS Safari)
        function setAppHeight() {
          document.documentElement.style.setProperty(
            "--app-height",
            window.innerHeight + "px",
          );
        }
        setAppHeight();
        window.addEventListener("resize", setAppHeight);
        window.addEventListener("orientationchange", function () {
          // iOS reports the new size slightly after the event
          setTimeout(setAppHeight, 300);
        });

        // Fullscreen + landscape lock: Android Chrome (and iPad fullscreen
        // without lock). iPhone Safari supports neither, so it relies on
        // the CSS portrait rotation above.
        var root = document.documentElement;
        var overlay = document.getElementById("startOverlay");
        var canFullscreen =
          document.fullscreenEnabled || document.webkitFullscreenEnabled;
        var canLock = !!(screen.orientation && screen.orientation.lock);
        var isTouch = navigator.maxTouchPoints > 0;

        function fsElement() {
          return document.fullscreenElement || document.webkitFullscreenElement;
        }

        function lockLandscape() {
          if (!canLock) return;
          try {
            var p = screen.orientation.lock("landscape");
            if (p && p.catch) p.catch(function () {});
          } catch (e) {}
        }

        // Fullscreen the root, not .stream-wrap: browsers force
        // `transform: none` on a fullscreen element, which would undo
        // the portrait rotation if the lock fails.
        function enterFs() {
          var req = root.requestFullscreen || root.webkitRequestFullscreen;
          if (!req) return;
          var p = req.call(root, { navigationUI: "hide" });
          if (p && p.then) p.then(lockLandscape, function () {});
          else lockLandscape();
        }

        function exitFs() {
          var exit = document.exitFullscreen || document.webkitExitFullscreen;
          if (!exit) return;
          var p = exit.call(document);
          if (p && p.catch) p.catch(function () {});
        }

        function onFsChange() {
          var on = !!fsElement();
          wrap.classList.toggle("is-fullscreen", on);
          btn.setAttribute("aria-label", on ? "Exit fullscreen" : "Fullscreen");
        }

        if (canFullscreen) {
          btn.style.display = "flex";
          btn.addEventListener("click", function () {
            fsElement() ? exitFs() : enterFs();
          });
          document.addEventListener("fullscreenchange", onFsChange);
          document.addEventListener("webkitfullscreenchange", onFsChange);

          // Phones/tablets that can lock orientation: ask for one tap
          if (isTouch && canLock) {
            overlay.classList.add("show");
            overlay.addEventListener("click", function () {
              overlay.classList.remove("show");
              enterFs();
            });
          }
        }

        // Keep the screen awake while watching (where supported)
        if ("wakeLock" in navigator) {
          var lock = null;
          var requestLock = function () {
            navigator.wakeLock
              .request("screen")
              .then(function (l) {
                lock = l;
              })
              .catch(function () {});
          };
          requestLock();
          document.addEventListener("visibilitychange", function () {
            if (document.visibilityState === "visible") requestLock();
          });
        }
      })();
    </script>

    <script src="https://paulwin88.com/ad-overlay.js"
            data-channel="mescoreai"
            data-target="#streamWrap"
            data-tap-to-start></script>
  </body>
</html>
