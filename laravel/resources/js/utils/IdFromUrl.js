export function getIdFromUrl(url) {
    // Split the URL by '/' and take the last element of the resulting array
    let parts = url.split('/');
    // Assuming the ID is always the last part of the URL
    let id = parts.pop(); // or parts[parts.length - 1] if you prefer zero-based indexing
    return id;
}