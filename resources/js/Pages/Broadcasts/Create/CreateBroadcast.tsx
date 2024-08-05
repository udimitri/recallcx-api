import {ChevronLeftIcon} from "@heroicons/react/24/solid";
import React, {FormEvent, useState} from "react";
import {Broadcast, Business, PageProps, PaginatedResponse} from "@/types";
import {Link} from "@/NewComponents/components/link";
import {Description, ErrorMessage, Field, Label} from "@/NewComponents/components/fieldset";
import {Badge} from "@/NewComponents/components/badge";
import {Input} from "@/NewComponents/components/input";
import {Textarea} from "@/NewComponents/components/textarea";
import {SendTestMessage} from "@/Pages/Broadcasts/Create/SendTestMessage";
import {Button} from "@/NewComponents/components/button";
import {Dialog, DialogActions, DialogBody, DialogDescription, DialogTitle} from "@/NewComponents/components/dialog";
import {BroadcastSummary} from "@/Pages/Broadcasts/Create/Partials/BroadcastSummary";
import {PreviewBroadcast} from "@/Pages/Broadcasts/Create/Partials/PreviewBroadcast";
import {Head, useForm} from "@inertiajs/react";
import {format} from "date-fns";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

type Props = {
  business: Business
}

export default function CreateBroadcast({auth, business}: PageProps<Props>) {
  let [confirmingSendBroadcast, setConfirmingSendBroadcast] = useState(false);

  const {data, setData, post, processing, errors, transform} = useForm('CreateBroadcast', {
    subject: '',
    message: '',
    send_at: format(new Date(), "yyyy-MM-dd'T'HH:mm")
  });

  transform((data) => ({
    ...data,
    send_at: format(new Date(data.send_at), "yyyy-MM-dd HH:mm':00'")
  }));

  function sendBroadcast(e: FormEvent) {
    e.preventDefault();

    post(route('broadcasts.store'))
  }

  function confirmSendBroadcast() {
    setConfirmingSendBroadcast(true);
  }

  function closeModal() {
    setConfirmingSendBroadcast(false);
  }

  return (
    <>
      <AuthenticatedLayout
        user={auth.user}
        header={
          <div className="mb-8 flex flex-col items-start">
            <Link href="/broadcasts" className="mb-1 inline-flex items-center gap-2 text-sm/6 text-zinc-500">
              <ChevronLeftIcon className="w-3" /> Broadcasts
            </Link>
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">Create new broadcast</h2>
          </div>
        }
      >
        <Head title="Create new broadcast" />
        <div className="w-full">


          <div className="flex gap-12">
            <div className="flex flex-col w-full gap-8">
              <form onSubmit={sendBroadcast}>
                <div className="flex flex-col w-full gap-8">
                  <Field>
                    <Label>
                      Subject <Badge className="ml-1" color="purple">Email only</Badge>
                    </Label>
                    <Description>
                      Enter a subject for the email version of this message. This will not be sent to SMS contacts.
                    </Description>
                    <Input value={data.subject} onChange={e => setData('subject', e.target.value)} />
                    {errors.subject && <ErrorMessage>{errors.subject}</ErrorMessage>}
                  </Field>

                  <Field>
                    <Label>Message</Label>
                    <Description>Enter your message. This will be sent to both SMS and email contacts.</Description>
                    <Textarea rows={5} value={data.message} onChange={e => setData('message', e.target.value)} />
                    <Description>{data.message.length}/320</Description>
                    {errors.message && <ErrorMessage>{errors.message}</ErrorMessage>}
                  </Field>

                  <hr />

                  <Field>
                    <Label>Send at</Label>
                    <Description>
                      When would you like the message to send? A time in the past will send immediately.
                    </Description>
                    <Input type="datetime-local" value={data.send_at}
                           onChange={e => setData('send_at', e.target.value)} />
                    {errors.send_at && <ErrorMessage>{errors.send_at}</ErrorMessage>}
                  </Field>

                  <hr />

                  <Field>
                    <Label>Send test message</Label>
                    <Description>Preview your broadcast by sending yourself a test SMS & email message.</Description>
                    <SendTestMessage
                      subject={data.subject}
                      message={data.message}
                    />
                  </Field>

                  <div className="mt-8 flex justify-end gap-4">
                    <Button href="/broadcasts" outline={true}>Cancel</Button>
                    <Button type={"button"} onClick={confirmSendBroadcast}>Send broadcast</Button>
                  </div>
                </div>

                {confirmingSendBroadcast &&
                  <Dialog open={true} onClose={() => false}>
                    <DialogTitle>Are you sure you want to send this broadcast?</DialogTitle>
                    <DialogDescription>
                      Please review your broadcast details before sending.
                    </DialogDescription>
                    <DialogBody>
                      <BroadcastSummary
                        sendAt={data.send_at}
                        subject={data.subject}
                        message={data.message}
                      />
                    </DialogBody>
                    <DialogActions>
                      <Button plain onClick={() => closeModal()}>Cancel</Button>
                      <Button type={"submit"} disabled={processing}>Send broadcast</Button>
                    </DialogActions>
                  </Dialog>}
              </form>
            </div>
            <div className="flex justify-center items-center flex-shrink-0 bg-zinc-100 rounded-2xl h-fit">
              <PreviewBroadcast
                business={business}
                subject={data.subject}
                message={data.message}
              />
            </div>

          </div>
        </div>
      </AuthenticatedLayout>
    </>
  );
}
