export const checkPermission = (permission: string) => {
    const allPermissions = JSON.parse(localStorage.getItem('permissions') || '[]');
    return allPermissions.some((element: any) => {
        return element.name === permission;
    });
}
