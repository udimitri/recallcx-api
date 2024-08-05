import {PropsWithChildren, ReactNode} from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import {Link} from '@inertiajs/react';
import {User} from '@/types';
import SideNavLink from "@/Components/SideNavLink";
import {EllipsisHorizontalIcon} from "@heroicons/react/20/solid";

export default function Authenticated({user, header, children}: PropsWithChildren<{ user: User, header?: ReactNode }>) {
  return (
    <div className="min-h-screen">
      <div className="flex gap-16 w-full h-full px-8">
        <div className="w-[250px] pb-4 min-h-screen flex flex-col justify-between">
          <div className="shrink-0 flex items-center h-24">
            <Link href="/">
              <ApplicationLogo className="block h-7 w-auto text-gray-800" />
            </Link>
          </div>

          <div className="flex flex-col flex-grow">
            <SideNavLink href={route('dashboard')} active={route().current().startsWith('dashboard')}>
              Home
            </SideNavLink>
            <SideNavLink href={route('reviews')} active={route().current().startsWith('reviews')}>
              Reviews
            </SideNavLink>
            <SideNavLink href={route('broadcasts')} active={route().current().startsWith('broadcasts')}>
              Broadcasts
            </SideNavLink>
            <SideNavLink href={route('audience')} active={route().current().startsWith('audience')}>
              Audience
            </SideNavLink>
          </div>

          <div className="flex items-center gap-2 ">
            <div className="flex items-center justify-center w-6 h-6 bg-black text-white rounded-full text-xs font-bold">D</div>
            <span className="font-bold flex-grow text-sm leading-[14px]">Dimitri Trofimuk</span>
            <EllipsisHorizontalIcon className="w-5" />
          </div>
        </div>

        <div className="w-full">
          {header && (
            <header className="bg-white h-24">
              <div className="mx-auto py-6">{header}</div>
            </header>
          )}

          <main>{children}</main>
        </div>
      </div>
    </div>
  );
}
