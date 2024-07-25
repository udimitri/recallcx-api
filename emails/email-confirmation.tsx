import {
  Body,
  Container,
  Head,
  Heading,
  Html,
  Link,
  Text,
  Tailwind, Section,
} from "@react-email/components";
import * as React from "react";
import {emailTailwindConf} from "./config";

interface EmailConfirmationEmailProps {
  companyName: string;
  companyAddress: string;
  discount: string;
  unsubscribeUrl: string;
}

export const EmailConfirmationEmail = (
  {
    companyName,
    companyAddress,
    discount,
    unsubscribeUrl
  }: EmailConfirmationEmailProps
) => {
  return (
    <Html>
      <Head />
      <Tailwind config={emailTailwindConf}>
        <Body className="bg-white my-auto mx-auto font-sans px-2">
          <Container className="mt-[40px]">
            <Section className="border border-solid border-[#eaeaea] rounded-lg p-[20px] max-w-[465px]">
              <Heading className="text-black text-[38px] font-normal text-center p-0 mb-0 leading-none">
                🎉🎉🎉
              </Heading>
              <Heading className="text-black text-[24px] font-normal text-center p-0 mt-[20px] mb-[30px] mx-[30px]">
                <strong>{companyName}</strong> wants to give you <strong>{discount}</strong>!
              </Heading>

              <Text>
                Thanks for sharing your email! Show this email to our team member to
                receive <strong>{discount}</strong> your purchase.
              </Text>

              <Text>
                Keep an eye on your inbox for exclusive deals, special offers and updates on new products. You can
                unsubscribe at any time.
              </Text>
            </Section>

            <Section className="mt-[10px] text-center text-[#bbbbbb]">
              <Text className="leading-none mb-0 text-xs">
                {companyName}
              </Text>
              <Text className="leading-none mt-[2px] text-xs">
                {companyAddress}
              </Text>
              <Text className="leading-none mt-0 text-xs">
                If you would like to stop receiving emails, you
                can <Link href={unsubscribeUrl} className="text-[#bbbbbb] underline">unsubscribe</Link>.
              </Text>
            </Section>
          </Container>
        </Body>
      </Tailwind>
    </Html>
  );
};

EmailConfirmationEmail.PreviewProps = {
  companyName: "CHIC Circular Fashion",
  companyAddress: "12529 102 Ave NW, Edmonton, AB T5N 0M4",
  discount: "$5 off",
} as EmailConfirmationEmailProps;

export default EmailConfirmationEmail;
