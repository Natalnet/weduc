import ClassroomsEnrolled from '@/views/ClassroomsEnrolled'
import ClassroomsIndex from '@/views/ClassroomsIndex'

export default [
    {
        name: 'classrooms',
        path: '/classrooms',
        component: ClassroomsIndex,
        props: true,
    },
    {
        name: 'classrooms.enrolled',
        path: '/classrooms/enrolled',
        component: ClassroomsEnrolled,
        props: true,
    },

    // {
    //     name: 'action-events.edit',
    //     path: '/resources/action-events/:id/edit',
    //     redirect: {
    //         name: '404',
    //     },
    // },
    // {
    //     name: 'index',
    //     path: '/resources/:resourceName',
    //     component: ResourceIndex,
    //     props: true,
    // },
    // {
    //     name: 'lens',
    //     path: '/resources/:resourceName/lens/:lens',
    //     component: Lens,
    //     props: true,
    // },
    // {
    //     name: 'create',
    //     path: '/resources/:resourceName/new',
    //     component: CreateResource,
    //     props: route => {
    //         return {
    //             resourceName: route.params.resourceName,
    //             viaResource: route.query.viaResource,
    //             viaResourceId: route.query.viaResourceId,
    //             viaRelationship: route.query.viaRelationship,
    //         }
    //     },
    // },
    // {
    //     name: 'edit',
    //     path: '/resources/:resourceName/:resourceId/edit',
    //     component: UpdateResource,
    //     props: route => {
    //         return {
    //             resourceName: route.params.resourceName,
    //             resourceId: route.params.resourceId,
    //             viaResource: route.query.viaResource,
    //             viaResourceId: route.query.viaResourceId,
    //             viaRelationship: route.query.viaRelationship,
    //         }
    //     },
    // },
    // {
    //     name: 'attach',
    //     path: '/resources/:resourceName/:resourceId/attach/:relatedResourceName',
    //     component: AttachResource,
    //     props: route => {
    //         return {
    //             resourceName: route.params.resourceName,
    //             resourceId: route.params.resourceId,
    //             relatedResourceName: route.params.relatedResourceName,
    //             viaRelationship: route.query.viaRelationship,
    //             polymorphic: route.query.polymorphic == '1',
    //         }
    //     },
    // },
    // {
    //     name: 'edit-attached',
    //     path:
    //         '/resources/:resourceName/:resourceId/edit-attached/:relatedResourceName/:relatedResourceId',
    //     component: UpdateAttachedResource,
    //     props: route => {
    //         return {
    //             resourceName: route.params.resourceName,
    //             resourceId: route.params.resourceId,
    //             relatedResourceName: route.params.relatedResourceName,
    //             relatedResourceId: route.params.relatedResourceId,
    //             viaRelationship: route.query.viaRelationship,
    //         }
    //     },
    // },
    // {
    //     name: 'detail',
    //     path: '/resources/:resourceName/:resourceId',
    //     component: ResourceDetail,
    //     props: true,
    // },
    // {
    //     name: '403',
    //     path: '/403',
    //     component: Error403,
    // },
    // {
    //     name: '404',
    //     path: '/404',
    //     component: Error404,
    // },
    // {
    //     name: 'catch-all',
    //     path: '*',
    //     component: Error404,
    // },
]