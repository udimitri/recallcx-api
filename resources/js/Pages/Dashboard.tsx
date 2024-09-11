import React from "react";
import {
  ArrowTrendingUpIcon,
  BuildingStorefrontIcon,
} from "@heroicons/react/24/solid";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import {DashboardRowReport, PageProps} from '@/types';
import {Button} from "@/NewComponents/components/button";
import {GrowthChart} from "@/Pages/Partials/GrowthChart";
import {ChatBubbleLeftEllipsisIcon, PaperAirplaneIcon, UserIcon} from "@heroicons/react/24/outline";


type Props = {
  business: {
    name: string,
    address: string,
  },
  audience: DashboardRowReport,
  reviews: DashboardRowReport
}

function DashboardRow({
  label,
  row,
  actions,
}: {
  label: string,
  row: DashboardRowReport,
  actions: React.ReactNode,
}) {
  return (
    <div className="flex justify-between items-start gap-12 rounded-xl p-4">
      <div className="flex flex-col gap-2">
        <h5 className="text-xl font-medium">{label}</h5>
        <p className="text-4xl font-bold">{row.count ?? 'N/A'}</p>
        <p className="text-green-600">
          {(row.change && row.change > 0) && (<>
            <ArrowTrendingUpIcon className="w-5 inline-block align-text-bottom" /> +{row.change} last 30 days
          </>)}
        </p>
        <div className="mt-3 flex gap-4">
          {actions}
        </div>
      </div>
      <div className="h-[175px] w-full max-w-[50%]">
        <GrowthChart data={row.last7} />
      </div>
    </div>
  );
}

export default function Dashboard({auth, business, audience, reviews}: PageProps<Props>) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      business={auth.business}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Overview</h2>}
    >
      <Head title="Dashboard" />

      <div>
        <div className="mb-12">
          <h5 className="font-medium text-zinc-600 mb-2">Quick actions</h5>

          <div className="grid grid-cols-4 gap-8">
            <div className="flex flex-col items-center justify-center bg-zinc-100 rounded-md p-4 ">
              <PaperAirplaneIcon className="w-6" />
              <span>Send broadcast</span>
              <p className="text-xs text-center">Quickly send an email or SMS message to your entire audience.</p>
            </div>
            <div className="flex flex-col items-center justify-center bg-zinc-100 rounded-md p-4 ">
              <ChatBubbleLeftEllipsisIcon className="w-6" />
              <span>View review requests</span>
              <p className="text-xs text-center">Review how often you are sending our new review requests.</p>
            </div>
            <div className="flex flex-col items-center justify-center bg-zinc-100 rounded-md p-4 ">
              <UserIcon className="w-6" />
              <span>Manage audience</span>
              <p className="text-xs text-center">See who's in your audience and remove contacts.</p>
            </div>
          </div>
        </div>

        <div className="grid grid-cols-4 mb-12">
          <div>
            <h5 className="font-medium text-zinc-600 mb-2">Audience size</h5>
            <span className="text-3xl font-bold">{audience.count ?? 'N/A'}</span>
            <p className="text-green-600">
              {(audience.change && audience.change > 0) && (<>
                <ArrowTrendingUpIcon className="w-5 inline-block align-text-bottom" /> +{audience.change} last 30 days
              </>)}
            </p>
          </div>
          <div>
            <h5 className="font-medium text-zinc-600 mb-2">Review count</h5>
            <span className="text-3xl font-bold">{reviews.count ?? 'N/A'}</span>
            <p className="text-green-600">
              {(audience.change && audience.change > 0) && (<>
                <ArrowTrendingUpIcon className="w-5 inline-block align-text-bottom" /> +{audience.change} last 30 days
              </>)}
            </p>
          </div>
        </div>

        <div className="grid grid-cols-4">
          <div className="col-span-2 pr-16">
            <h5 className="font-medium text-zinc-600 mb-2">Audience growth</h5>
            <div className="h-[200px] w-full">
              <GrowthChart data={audience.last7} />
            </div>
          </div>
          <div className="col-span-2 pr-16">
            <h5 className="font-medium text-zinc-600 mb-2">Review growth</h5>
            <div className="h-[200px] w-full">
              <GrowthChart data={audience.last7} />
            </div>
          </div>
        </div>


        <div className="grid gap-8 hidden">
          <DashboardRow
            label={'Audience'}
            row={audience}
            actions={<>
              <Button href={"/broadcasts"}>View broadcasts</Button>
              <Button href={"/audience"} outline={true}>View audience</Button>
            </>}
          />

          <hr />

          <DashboardRow
            label={'Reviews'}
            row={reviews}
            actions={<>
              <Button href={"/reviews"}>View reviews</Button>
            </>}
          />
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
