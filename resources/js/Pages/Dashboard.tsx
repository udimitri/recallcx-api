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


type Props = {
  business: {
    name: string,
    address: string,
  },
  audience: DashboardRowReport,
  reviews: DashboardRowReport
}


function BusinessHeading({
  name,
  address
}: {
  name: string,
  address: string
}) {
  return (
    <div className="flex items-center gap-4 rounded-xl p-4 bg-zinc-100">
      <div className="w-16 h-16 bg-zinc-200 rounded-full flex justify-center items-center">
        <BuildingStorefrontIcon className="w-10 text-zinc-600" />
      </div>

      <div className="flex flex-col">
        <h2 className="text-xl font-semibold">{name}</h2>
        <p>{address}</p>
      </div>
    </div>
  );
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
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
    >
      <Head title="Dashboard" />

      <div>
        <div className="grid gap-8">
          <BusinessHeading
            name={business.name}
            address={business.address}
          />

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
