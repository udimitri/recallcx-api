import { Link, InertiaLinkProps } from '@inertiajs/react';

export default function SideNavLink({ active = false, className = '', children, ...props }: InertiaLinkProps & { active: boolean }) {
    return (
        <Link
            {...props}
            className={
                'inline-flex items-center pl-4 -ml-4 pr-4 py-2 rounded-lg leading-5 transition duration-150 ease-in-out focus:outline-none ' +
                (active
                    ? 'text-[#29A4D6] font-semibold'
                    : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300 ') +
                className
            }
        >
            {children}
        </Link>
    );
}
