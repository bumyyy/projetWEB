const addResourcesToCache = async (resources) => {
    const cache = await caches.open("v1");
    await cache.addAll(resources);
  };
  
  const putInCache = async (request, response) => {
    // Assurez-vous que seules les requêtes HTTP/HTTPS sont mises en cache
    if (request.url.startsWith('http://') || request.url.startsWith('https://')) {
      const cache = await caches.open("v1");
      await cache.put(request, response);
    }
  };
  
  const cacheFirst = async ({ request, preloadResponsePromise, fallbackUrl }) => {
    // Pour commencer on essaie d'obtenir la ressource depuis le cache
    const responseFromCache = await caches.match(request);
    if (responseFromCache) {
      return responseFromCache;
    }
  
    // Ensuite, on tente d'utiliser et de mettre en cache
    // la réponse préchargée si elle existe
    const preloadResponse = await preloadResponsePromise;
    if (preloadResponse) {
      console.info("using preload response", preloadResponse);
      putInCache(request, preloadResponse.clone());
      return preloadResponse;
    }
  
    // Ensuite, on tente de l'obtenir du réseau
    try {
      const responseFromNetwork = await fetch(request);
      // Une réponse ne peut être utilisée qu'une fois
      // On la clone pour en mettre une copie en cache
      // et servir l'originale au navigateur
      putInCache(request, responseFromNetwork.clone());
      return responseFromNetwork;
    } catch (error) {
      const fallbackResponse = await caches.match(fallbackUrl);
      if (fallbackResponse) {
        return fallbackResponse;
      }
      // Quand il n'y a même pas de contenu par défaut associé
      // on doit tout de même renvoyer un objet Response
      return new Response("Network error happened", {
        status: 408,
        headers: { "Content-Type": "text/plain" },
      });
    }
  };
  
  // On active le préchargement à la navigation
  const enableNavigationPreload = async () => {
    if (self.registration.navigationPreload) {
      await self.registration.navigationPreload.enable();
    }
  };
  
  self.addEventListener("activate", (event) => {
    event.waitUntil(enableNavigationPreload());
  });
  
  self.addEventListener("install", (event) => {
    event.waitUntil(
      addResourcesToCache([
        "/",
      ]),
    );
  });
  
  self.addEventListener("fetch", (event) => {
    event.respondWith(
      (async () => {
        try {
          // Attendez la réponse du preload si elle est disponible
          const preloadResponse = await event.preloadResponse;
          if (preloadResponse) {
            return preloadResponse;
          }
  
          // Sinon, essayez de récupérer la réponse du cache
          const cachedResponse = await caches.match(event.request);
          if (cachedResponse) {
            return cachedResponse;
          }
  
          // Si rien n'est en cache, allez chercher la ressource sur le réseau
          const networkResponse = await fetch(event.request);
          
          // Mettez en cache la ressource récupérée sur le réseau pour de futures requêtes
          const cache = await caches.open("v1");
          // Assurez-vous que seules les requêtes HTTP/HTTPS sont mises en cache
          if (event.request.url.startsWith('http://') || event.request.url.startsWith('https://')) {
            cache.put(event.request, networkResponse.clone());
          }
          
          return networkResponse;
        } catch (error) {
          // Si tout échoue, renvoyez une réponse générique ou une page de secours
          console.error("Fetching failed; returning generic fallback:", error);
          return caches.match('/fallback.html') || new Response("Offline", { status: 408 });
        }
      })()
    );
  });
  