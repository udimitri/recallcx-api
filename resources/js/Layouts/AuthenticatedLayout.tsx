import React, {PropsWithChildren, ReactNode} from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import {Link} from '@inertiajs/react';
import {Business, User} from '@/types';
import SideNavLink from "@/Components/SideNavLink";
import {EllipsisHorizontalIcon} from "@heroicons/react/20/solid";
import {HomeIcon, ChatBubbleLeftEllipsisIcon, UserGroupIcon, MegaphoneIcon} from "@heroicons/react/20/solid";
import {BuildingStorefrontIcon} from "@heroicons/react/24/solid";

function BusinessHeading({
  name,
  address
}: {
  name: string,
  address: string
}) {
  return (
    <div className="flex items-center gap-4 p-4 bg-zinc-100">
      <div className="w-12 h-12 bg-zinc-200 rounded-md flex justify-center items-center">
        <BuildingStorefrontIcon className="w-8 text-zinc-600" />
      </div>

      <div className="flex flex-col">
        <h2 className="font-semibold">{name}</h2>
        <p className="text-sm">{address}</p>
      </div>
    </div>
  );
}

export default function Authenticated({
  user,
  business,
  header,
  children
}: PropsWithChildren<{ user: User, business: Business, header?: ReactNode }>) {
  return (
    <div className="min-h-screen">
      <div className="flex w-full h-full">
        <div className="w-[250px] pb-4 min-h-screen flex flex-col justify-between border-r px-8">
          <div className="shrink-0 flex items-center h-24">
            <Link href="/">
              <ApplicationLogo className="block h-7 w-auto text-gray-800" />
            </Link>
          </div>

          <div className="flex flex-col flex-grow">
            <SideNavLink href={route('dashboard')} active={route().current().startsWith('dashboard')}>
              <HomeIcon className="w-5 mr-2" />
              Home
            </SideNavLink>
            <SideNavLink href={route('reviews')} active={route().current().startsWith('reviews')}>
              <ChatBubbleLeftEllipsisIcon className="w-5 mr-2" />
              Reviews
            </SideNavLink>
            <SideNavLink href={route('broadcasts')} active={route().current().startsWith('broadcasts')}>
              <MegaphoneIcon className="w-5 mr-2" />
              Broadcasts
            </SideNavLink>
            <SideNavLink href={route('audience')} active={route().current().startsWith('audience')}>
              <UserGroupIcon className="w-5 mr-2" />
              Audience
            </SideNavLink>
          </div>

          <div className="flex items-center gap-2 ">
            <div
              className="flex items-center justify-center w-6 h-6 bg-black text-white rounded-full text-xs font-bold">D
            </div>
            <span className="font-bold flex-grow text-sm leading-[14px]">Dimitri Trofimuk</span>
            <EllipsisHorizontalIcon className="w-5" />
          </div>
        </div>

        <div className="w-full">
          <BusinessHeading
            name={business.name}
            address={business.address}
          />

          <section className="px-8">
            {header && (
              <header>
                <div className="mx-auto py-6">{header}</div>
              </header>
            )}

            <main>{children}</main>
          </section>
        </div>
      </div>
    </div>
  );
}
