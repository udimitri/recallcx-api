import React from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import {AudienceMetrics, Contact, DashboardLast7Report, PageProps, PaginatedResponse} from '@/types';
import {GrowthChart} from "@/Pages/Partials/GrowthChart";
import {AudienceTable} from "@/Pages/Audience/Partials/AudienceTable";

type Props = {
  metrics: AudienceMetrics,
  last7: DashboardLast7Report,
  paginatedContacts: PaginatedResponse<Contact>
}

export default function Audience({auth, metrics, last7, paginatedContacts}: PageProps<Props>) {
  const cards = [
    {label: "Subscribed", metric: metrics.subscribed},
    {label: "Phone numbers", metric: metrics.phone},
    {label: "Email address", metric: metrics.email},
    {label: "Unsubscribed", metric: metrics.unsubscribed},
  ];

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Audience</h2>}
    >
      <Head title="Dashboard" />

      <div>
        <div className="mt-8 grid grid-cols-4 gap-4">
          {cards.map(({label, metric}) => (
            <div key={label}
                 className="mb-8 flex flex-col items-center justify-center gap-1 rounded-xl p-4 bg-zinc-100">
              <div className="text-3xl font-bold">{metric}</div>
              <p className="text-zinc-500">{label}</p>
            </div>
          ))}
        </div>

        <p className="text-zinc-500 mb-2 text-sm">Subscribers - last 7 days</p>
        <div className="mb-12">
          <div className="h-[175px] w-full">
            <GrowthChart data={last7} />
          </div>
        </div>

        <AudienceTable data={paginatedContacts} />
      </div>
    </AuthenticatedLayout>
  );
}
