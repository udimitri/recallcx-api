import React from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import {Broadcast, PageProps, PaginatedResponse} from '@/types';
import {PlusIcon} from "@heroicons/react/16/solid";
import {Button} from "@/NewComponents/components/button";
import {BroadcastTable} from "@/Pages/Broadcasts/Partials/BroadcastTable";

type Props = {
  paginatedBroadcasts: PaginatedResponse<Broadcast>
}

export default function Broadcasts({auth, paginatedBroadcasts}: PageProps<Props>) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="mb-8 flex items-center justify-between">
          <h2 className="font-semibold text-xl text-gray-800 leading-tight">Broadcasts</h2>
          <Button href="/broadcasts/create">
            <PlusIcon />
            Create broadcast
          </Button>
        </div>
      }
    >
      <Head title="Broadcasts" />

      <BroadcastTable data={paginatedBroadcasts} />
    </AuthenticatedLayout>
  );
}
